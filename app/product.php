<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class product extends Model
{
    use SoftDeletes;
    protected $table = "products";
 
        protected $fillable = [
            'product_code',
            'Product_name',
            'slug',
            'description',
            'image',
            'price',
            'price_promo',
            'discount',
            'stock',
            'low_stock_treshold',
            'top_product',
            'created_at',
            'updated_at',
            'status'
        ];
        
        public function categories(){
            return $this->belongsToMany('App\Category','category_product','product_id','category_id')->withPivot('category_id');
        }

        public function orders(){
            return $this->belongsToMany('App\Order');
        }

        public function groups(){
            return $this->belongsToMany('App\Group')->wherePivot('status', 'ACTIVE');
        }

        
}
