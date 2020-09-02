<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Item;

class UserCartController extends Controller
{   
    //カートに入れる処理
    public function add($id)
    {   
        \Auth::user()->addToCart($id, 1);
        $user_id = \Auth::id();
        return redirect(route('myCart', [
        'id' => $user_id,
        ]));
    }
    //カートの中身を表示する
    public function index($id)
    {
        $user = User::find($id);
        $my_carts = $user->cart()->paginate(10);
        
        
        $data = [
            'user' => $user,
            'my_carts' => $my_carts, 
            ];
            
        return view('users.cart', $data);
    }
    
    public function countItem(Request $request, $item_id)
    {
        
        
        if($request->item_number_describe==0)
        {
            \Auth::user()->removeToCart($item_id);
        }else{
            $user_id = \Auth::id();
            $user = User::find($user_id);
            $cartItem = $user->userCarts()->where('item_id', $item_id)->first();
            $cartItem->number = $request->item_number_describe;
            $cartItem->save();
            
        }
        return back();
    }
}
