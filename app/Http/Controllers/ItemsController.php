<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Item;
use App\User;
use App\Shipping;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Arr;

use StripeService;
use Illuminate\Support\Facades\DB;

use App\ItemImage;


class ItemsController extends Controller
{   
    // テスト
    public function test(){
        $data = [];
        $recent_items = Item::orderBy('created_at', 'desc')->paginate(4);
        
        $data = [
            'recent_items' => $recent_items,
            ];
            
        return view('test', $data);
    }
    //トップページ
    public function top(){

        $data = [];
        $recent_items = Item::orderBy('created_at', 'desc')->paginate(4);
        
        $data = [
            'recent_items' => $recent_items,
            ];
            
        return view('welcome', $data);
    }
    
    //出品フォームページ
    public function index()
    {
        return view('items.index');
    }
    //入力確認ページへ
    public function registerItemConfirm(Request $request)
    {   
        //バリデーション
        $this->validate($request, [
            'item_name' => 'required|max:255',
            'list_price' => 'required|integer|digits_between:1,8|min:0',
            'sale_price' => 'required|integer|digits_between:1,8|min:0',
            'description' => 'string',
            'item_image' => 'required|file|image|mimes:jpeg,png',
            'item_images.*' => 'file|image|mimes:jpeg,png',
        ]);

        
        
        //商品名
        $item_name = $request->item_name;
        //定価
        $list_price = $request->list_price;
        //売値
        $sale_price = $request->sale_price;
        //商品の説明
        $description = $request->description;
        //s3アップロード開始
        $item_image = $request->file('item_image');
        //バケットの`myprefix`フォルダへアップロード
        $path = Storage::disk('s3')->putFile('myprefix', $item_image, 'public');
        //アップロードしたファイルのフル���スを取得
        $image_path = Storage::disk('s3')->url($path);
        
        $item_images = $request->item_images;
        
        // サブ画像保存
        // $sub_image_paths = [];
        // for($i = 0; $i <= 8; $i++){
        //     // $item_image_{$i} = $item_image . $i;
        //     // $file_name = 'item_image' . $i;
        //     $file_name = 'item_images['.$i.']';
        //     if(!is_null($item_images[$i])){
        //         $sub_item_image = $request->file($file_name);
        //         $sub_path = Storage::disk('s3')->putFile('myprefix', $sub_item_image, 'public');
        //         $sub_image_paths[$i] = Storage::disk('s3')->url($sub_path);
        //     }else{
        //         $sub_image_paths[$i] = null;
        //     }
        // }
        $sub_images = $request->file('item_images');
        $sub_image_paths = [];
        foreach($sub_images as $sub_image){
            $sub_path = Storage::disk('s3')->putFile('myprefix', $sub_image, 'public');
            $sub_image_paths[] = Storage::disk('s3')->url($sub_path);
        }
        
        if(\Auth::check()){
            $user_id = \Auth::id();
            $data = array(
                'item_name' => $item_name,
                'list_price' => $list_price,
                'sale_price' => $sale_price,
                'description' => $description,
                'user_id' => $user_id,
                'item_image' => $image_path,
                'sub_item_images' => $sub_image_paths,
            );
        }
        
        $request->session()->put('data', $data);
        
        return view('items.confirm', compact('data'));
            
    }
    //出品確認ページ
    public function registerItemComplete(Request $request)
    {
        $data = $request->session()->get('data');
        
        $user = \Auth::user();
        
        //一気に保存
        DB::beginTransaction();
        try{
            $item = Item::create([
                //商品名
                'item_name' => $data['item_name'],
                //定価
                'list_price' => $data['list_price'],
                //売値
                'sale_price' => $data['sale_price'],
                //商品の説明
                'description' => $data['description'],
                //画像
                'image_url' => $data['item_image'],
                //ユーザーID
                'user_id' => $data['user_id'],
            ]);
            //StripeのProduct登録
            StripeService::createProduct($item);
            // サブ画像の保存
            if(!is_null($data['sub_item_images'])){
                foreach($data['sub_item_images'] as $sub_item_image){
                    if(!is_null($sub_item_image)){
                        ItemImage::create([
                            'item_id' => $item->id,
                            'image_url' => $sub_item_image,
                            ]);
                    }
                }
            }
            DB::commit();
        }catch(\Exception $e){
            dd($e->getMessage()) ;
            DB::rollback();
        }
        return view('items.complete');
    }
    //出品リスト(出品一覧ページ)
    public function showMyItems($id){
        $user = \Auth::user();
        $my_items = $user->items()->paginate(10);
        
        $data = [
            'user' => $user,
            'my_items' => $my_items
            ];
            
        return view('users.myExhibition', $data);
    }
    // デザインを見る
    public function showMyItemDesign($item_id){
        $item = Item::find($item_id);
        
        $item_images = $item->itemImages;
        
        $data = [
            'item' => $item,
            'sub_item_images' => $item_images,
            ];
        return view('users.showMyItemDesign', $data);
    }
    // 各商品の注文一覧(出品一覧から)
    public function orderMyItem($item_id){

        $item = Item::find($item_id);
        $shipping_items = $item-> shipping_items()->get();
        // $shippings = Shipping::whereIn('id',  $shipping_items->pluck('shipping_id'))->get();
        // $user = Shipping::whereIn('id',  $shipping_items->pluck('shipping_id'))->user()->get();
        $shippings = [];
        $users = [];
        foreach($shipping_items as $shipping_item) {
            $shipping = $shipping_item->shipping;
            $user = User::find($shipping->user_id);
            $shippings[] = $shipping;
            $users[] = $user;
        }
        $data = [
            'item' => $item,
            'shipping_items' => $shipping_items,
            'shippings' => $shippings,
            'users' => $users,
            ];

        
        //dd("test");
        
        return view('users.myItemOrder', $data);
    }
    //商品検索機能
    public function searchItem(Request $request)
    {
        //キーワードの取得
        $keyword = $request->input('search');

        // $this->validate($request, [
        //     'search' => 'required'
        // ]);
       
        //キーワードが入力されているなら、
        if(!empty($keyword))
        {
            
                    
            $results = \App\Item::where('item_name', 'like', '%'.$keyword.'%')->paginate(10);
            
                    
            $data = [
                'results' => $results,
                'keyword' => $keyword,
                ];
        }
        
            return view('items.search', $data);
    }
    
    //商品詳細ページの表示
    public function show(Request $request, $item_id){
        $item = Item::find($item_id);
        
        //閲覧履歴をセッションにて保存
        $browsing_items = Session::get('browsing', []);
        //dd($browsing_items);  
        
        if(in_array($item_id, $browsing_items)){
            array_unshift($browsing_items,$item_id);
            $browsing_items = array_unique($browsing_items);
        }else{
            if(count($browsing_items) > 5) {
                array_pop($browsing_items);
            }
            array_unshift($browsing_items,$item_id);
        }
        Session::put('browsing', $browsing_items);
        logger()->info('更新ID2', $browsing_items);
              
        // $sub_item_images = [];
        $item_image = $item->itemImages;
        
        return view('items.show', [
            'item' => $item,
            'sub_item_images' => $item_image,
            ]);
    }
}
