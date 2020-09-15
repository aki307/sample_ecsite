<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_kanji','name_kana', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function items()
    {
        return $this->hasMany(Item::class);
    }
    
    public function cart(){
        return $this->belongsToMany(Item::class, 'user_cart', 'user_id', 'item_id')->withTimestamps()->withPivot('number');
    }
    
    public function addToCart($ItemId, $number)
    {
        //既にカートに入れているかの確認
        $exist = $this->is_adding_to_cart($ItemId);
        
        if($exist){
            return false;
        } else {
        //カートに入っていないならばカートに入れる
        $this->cart()->attach($ItemId, ['number' => $number]);
        return true;
        }
    }
    
    public function removeToCart($ItemId)
    {
        //既にカートに入っているかの確認
        $exist = $this->is_adding_to_cart($ItemId);
        
        
        if($exist){
            $this->cart()->withPivot('number')->detach($ItemId);
            
        } else {
            return false;
        }
    }
    //個数変更仕様
    public function itemNumber($ItemId, $number)
    {
        //既にカートに入っているかの確認
        $exist = $this->is_adding_to_cart($itemId);
        
        if($exist){
            $this->cart()->sync($itemId, ['number' => $number]);
            return true;
        } else {
            return false;
        }
    }
    
    public function is_adding_to_cart($itemId)
    {
        return $this->cart()->where('item_id', $itemId)->exists();
    }
    
    public function userCarts()
    {
        return $this->hasMany(UserCart::class);
    }
    public function shippings()
    {
        return $this->hasMany(Shipping::class);
    }
    public function shipping_items()
    {
        return $this->hasManyThrough('App\ShippingItem', 'App\Item');
    }
}
