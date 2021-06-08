<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class product extends Model
{
    use SoftDeletes;
        public function categories(){
        return $this->belongsToMany('App\Category','category_product','product_id','category_id')->withPivot('category_id');
        }

        public function orders(){
        return $this->belongsToMany('App\Order');
        }

        
}
