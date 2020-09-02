<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingItem extends Model
{
    protected $fillable = ['item_id', 'quantity', 'sale_price', 'shipping_id','money_transfer','delivery_status'];
    
    public function shipping()
    {
        return $this->belongsTo(Shipping::class);
    }
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
