<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemImage extends Model
{
    protected $fillable = ['item_id', 'image_url'];
    
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
