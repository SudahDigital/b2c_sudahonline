<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{   
    protected $table = "customers";
 
    protected $fillable = ['store_code','name','email','phone','store_name','city_id','address','payment_term'];

    public function users(){
        return $this->belongsTo('App\User','user_id');
    }

    public function cities(){
        return $this->belongsTo('App\City','city_id');
    }

}
