<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



class Item extends Model
{
    protected $fillable = ['item_name','list_price','sale_price','image_url','description','user_id'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function cart()
    {
        return $this->belongsToMany(Item::class, 'user_cart', 'item_id', 'user_id')->withTimestamps();
    }
    
    public function itemImages()
    {
        return $this->hasMany(ItemImage::class);
    }
    public function shipping_items(){
        return $this->hasMany(ShippingItem::class);
    }
}
