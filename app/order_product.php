<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order_product extends Model
{
    protected $table = 'order_product';
    protected $fillable = ['product_id', 
                            'order_id',
                            'group_id', 
                            'quantity',
                            'price_item',
                            'price_item_promo',
                            'discount_item',
                            'group_id',
                            'paket_id',
                            'bonus_cat'];
    
}
