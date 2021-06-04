<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    /*
    public function groups(){
        return $this->belongsToMany('App\Group','groups_paket','paket_id','group_id')->withPivot('group_id');
    }*/

    public function orders(){
        return $this->belongsToMany('App\order_product','paket_id');
    }
}
