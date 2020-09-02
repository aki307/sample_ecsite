<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shipping;
use Illuminate\Support\Facades\DB;
use App\ShippingItem;
use App\User;
use App\UserCart;
use App\Item;

class ShippingItemsController extends Controller
{
    public function complete()
    {   
        $user = \Auth::user();
        $my_carts = $user->cart()->get();
        $shipping_id = $user->shippings()->latest()->first()->id ;
        
        DB::beginTransaction();
        try{
            foreach($my_carts as $my_cart){
                $item_id = $my_cart->id;
                $quantity = $my_cart->pivot->number;
                $sale_price = $my_cart->sale_price;
            
            ShippingItem::create([
                'item_id' => $item_id,
                'quantity' => $quantity,
                'sale_price' => $sale_price,
                'shipping_id' => $shipping_id,
                'money_transfer' => '1',
                'delivery_status' => '1'
                ]);
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            return view('shipping.failure');
        }
        //カートの中身をからにする
        foreach($my_carts as $my_cart){
            $item_id = $my_cart->id;
            $user->removeToCart($item_id);
        }
        return view('shipping.complete');
    }
    //【仮説】出品した商品の状態
    public function showMyItemsStatus()
    {
        $user = \Auth::user();
        $my_item_status = $user->shipping_items()->get();
       
        $data=[
            'my_item_status'=> $my_item_status,
            // 'my_item_shippings' =>$my_item_shippings,
            ];
        return view('users.myItemsStatus',$data);
        
    }
    // 出品者から見るお客様の注文詳細ページ
    public function myItemOrderDetail($shipping_items_id)
    {   
        $shipping_item = ShippingItem::find($shipping_items_id);
        $item = Item::find($shipping_item->item_id);
        $shipping = $shipping_item->shipping;
        $customer = User::find($shipping->user_id);
        $data = [
            'shipping_item' => $shipping_item,
            'item' => $item,
            'shipping' =>$shipping,
            'customer' => $customer
            ];
        return view('users.myItemOrderDetail', $data);
    }
}
