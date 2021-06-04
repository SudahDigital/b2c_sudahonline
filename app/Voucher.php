<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use SoftDeletes;

    public function orders(){
        return $this->hasMany('App\Order');
    }
}
