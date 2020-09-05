<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Item;
use App\User;
use App\UserCart;
use App\Shipping;
use App\ShippingItem;
use Illuminate\Support\Facades\DB;
use StripeService;

class ShippingsController extends Controller
{
    public function index($id){
        
        $prefs = config('pref');
        //ユーザーIDの処理
        $user_id = \Auth::id();
        $data = array(
            'prefs' => $prefs,
            'user'=> $user_id
            );
        return view('shipping.form', $data);
    }
    
    public function session(Request $request){
        
        //バリデーション
        $this->validate($request, [
            'user_name' =>'required|max:255',
            'postal_corder' =>'required|integer',
            'address1' =>'required|string',
            'address2' =>'required|string',
            //（仮説）都道府県選択肢
            'prefIndex' => 'integer',
            //（仮説）支払方法選択式
            'payment' => 'integer',
            
            ]);
            
        //姓名（漢字）
        if(\Auth::check()){
            $user_id = \Auth::id();
            //セッションで保存
            $shipping = ['user_name' => $request->user_name,
                        'postal_corder' => $request->postal_corder,
                        'address1' => $request->address1,
                        'address2' => $request->address2,
                        //都道府県選択肢
                        'xmpf' => $request->prefIndex,
                        //支払方法選択肢
                        'payment' => $request->payment,];
                            
            session()->put(['shipping' => $shipping]);
        }
        return redirect(route('paymentConfirm', ['id' => $user_id]));
    }
    
    public function confirm(Request $request, $id){
        $user = User::find($id);
        $my_carts = $user->cart()->get();
        
        //セッションから取得する
        $shipping = $request->session()->get('shipping');
        
        
        $data = [
            'user' => $user,
            'my_carts' => $my_carts,
            'shipping' => $shipping
            ];
            
        return view('shipping.confirm', $data);
    }
    public function register(Request $request, $id)
    {   
        if(\Auth::check()){
            $user_id = \Auth::id();
            $user = \Auth::user();
            $session = $request->session()->get('shipping');
            $payment = $session['payment'];
            $shipping_xmpf = $session['xmpf'];
            $shipping_address1 = $session['address1'];
            $shipping_address2 = $session['address2'];
            
            $my_carts = $user->cart()->get();
            
            DB::beginTransaction();
            try{
                $shipping = Shipping::create([
                    'user_id' => $user_id,
                    'payment' => $payment,
                    'shipping_xmpf' => $shipping_xmpf,
                    'payment_state' => '1',
                    'shipping_address1' => $shipping_address1,
                    'shipping_address2' => $shipping_address2
                ]);
                foreach($my_carts as $my_cart){
                $item_id = $my_cart->id;
                $quantity = $my_cart->pivot->number;
                $sale_price = $my_cart->sale_price;
                ShippingItem::create([
                    'item_id' => $item_id,
                    'quantity' => $quantity,
                    'sale_price' => $sale_price,
                    'shipping_id' => $shipping->id,
                    'money_transfer' => '1',
                    'delivery_status' => '1'
                ]);
            }
                DB::commit();
            }catch(\Exception $e){
                dd($e->getMessage()) ;
                DB::rollback();
                return view('shipping.failure');
            }
            DB::beginTransaction();
            try{
                
                if($shipping->payment==1){
                    // TODO: ロジックをここに移動。クレジットカードの場合、Stripeのsessionを作りましょう。
                    // StripeService::createCheckoutSessionはsessionを作るのですから、returnでsessionオブジェクトかsessionIDを返す仕様が良いと思います。
                    $shipping_items = $shipping->shippingItems()->get();
                    $line_items = [];
                    foreach($shipping_items as $shipping_item){
                        $line_items[] = [
                      'price_data' => ['currency'=>'jpy', 'product' => 'ec-item-'.$shipping_item->item->id, 'unit_amount' => $shipping_item->sale_price],
                      'quantity'   => $shipping_item->quantity,
                        ];
                    }
                    $session_id = StripeService::createCheckoutSession($line_items);
                    
                    // 受け取ったsessionからsessionidを$shippingに代入して、save()
                    $shipping = Shipping::find($shipping->id);
                    $shipping->stripeid = $session_id;
                    
                    $shipping->save();
                    
                    DB::commit();
                }
            }catch(\Exception $e){
                    dd($e->getMessage());
                    DB::rollback();
            }
        }else{
            return false;
        }
        foreach($my_carts as $my_cart){
            $item_id = $my_cart->id;
            $user->removeToCart($item_id);
        }
        
        // TODO: Stripeのセッションなどをviewに渡し、決済ボタンに必要なデータをすべて渡してあげましょう。
        // TODO: viewの方で、決済ボタンを作って、ボタンを押したら、stripeの決済APIを呼ぶようにしましょう。
        if($shipping->payment==1){
        $data = ['session_id'=> $session_id,
            ];
        }else{
            $data[] = null;
        }
        return view('shipping.complete', $data);
    }
    //決済一覧表示機能
    public function table($id){
        if(\Auth::check()){
            $user = User::find($id);
            $shippings = $user->shippings()->orderBy('created_at', 'desc')->paginate(10);
            $data= [
                'user' => $user,
                'shippings' => $shippings,
                ];
        }
        return view('users.myOrder', $data);
    }
    
    //webhook機能
    public function webhook(){
        StripeService::webhook();
    }
    
    // お客様自身が見る注文詳細ページ
    public function myOrderDetail($shipping_id){
        $shipping = Shipping::find($shipping_id);
        $shipping_items = $shipping->shippingItems()->get();
        
        $data =[
            'shipping' => $shipping,
            'shipping_items' => $shipping_items,
            ];
        return view('users.myOrderDetail', $data);
    }
    // 【クレジット決済成功時】
    public function creditComplete()
    {   
        dd(url()->previous());
        return view('users.credit_complete');
    }
}
