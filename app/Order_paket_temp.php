<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_paket_temp extends Model
{
    protected $table = 'order_paket_tmp';
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
