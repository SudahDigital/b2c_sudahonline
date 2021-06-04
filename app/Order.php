<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    
    public function products(){
        return $this->belongsToMany('App\product')->withPivot('id','quantity','price_item','price_item_promo','discount_item','group_id','paket_id','bonus_cat');
    }

    public function products_nonpaket(){
        return $this->belongsToMany('App\product')
        ->withPivot('id','quantity','price_item','price_item_promo','discount_item','group_id','paket_id','bonus_cat')
        ->wherePivot('paket_id',null)
        ->wherePivot('group_id',null);
    }

    public function products_pkt(){
        return $this->belongsToMany('App\product')
        ->withPivot('id','quantity','price_item','price_item_promo','discount_item','group_id','paket_id','bonus_cat')
        ->wherePivot('paket_id','!=',null)
        ->wherePivot('group_id','!=',null)
        ->wherePivot('bonus_cat','=',null);
    }

    public function products_bns(){
        return $this->belongsToMany('App\product')
        ->withPivot('id','quantity','price_item','price_item_promo','discount_item','group_id','paket_id','bonus_cat')
        ->wherePivot('group_id','!=',null)
        ->wherePivot('bonus_cat','!=',null);
    }

    public function products_pktbns(){
        return $this->belongsToMany('App\product')
        ->withPivot('id','quantity','price_item','price_item_promo','discount_item','group_id','paket_id','bonus_cat')
        ->wherePivot('paket_id','!=',null)
        ->wherePivot('group_id','!=',null);
    }

    public function pakets(){
        return $this->belongsToMany('App\Paket','order_product','order_id','paket_id');
    }

    public function groups(){
        return $this->belongsToMany('App\Group','order_product','order_id','group_id');
    }

    public function vouchers(){
        return $this->belongsTo('App\Voucher','id_voucher');
    }

    public function customers(){
        return $this->belongsTo('App\Customer','customer_id');
    }

    public function users(){
        return $this->belongsTo('App\User','user_id');
    }

    public function getTotalQuantityAttribute(){
        $total_quantity = 0;
        foreach($this->products as $p){
        $total_quantity += $p->pivot->quantity;
        }
        return $total_quantity;
    }


}
