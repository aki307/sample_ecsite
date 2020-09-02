<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $fillable = ['user_id', 'payment', 'shipping_xmpf','shipping_address1', 'shipping_address2','payment_state','stripeid'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function shippingItems()
    {
        return $this->hasMany(ShippingItem::class);
    }
}
