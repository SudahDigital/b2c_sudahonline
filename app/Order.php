<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    
    public function products(){
        return $this->belongsToMany('App\product')->withPivot('id','quantity','price_item','price_item_promo','discount_item');
    }

    public function vouchers(){
        return $this->belongsTo('App\Voucher','id_voucher');
    }

    public function getTotalQuantityAttribute(){
        $total_quantity = 0;
        foreach($this->products as $p){
        $total_quantity += $p->pivot->quantity;
        }
        return $total_quantity;
    }

}
