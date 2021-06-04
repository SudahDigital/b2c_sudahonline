<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /*public function pakets(){
        return $this->belongsToMany('App\Paket');
    }*/
    protected $fillable = [
        'created_at',
        'updated_at',
        'status',
        'version',
        'display_name',
        'group_name',
    ];
    public function products(){
        return $this->belongsToMany('App\product','group_product','group_id','product_id')->withPivot('id','group_id','product_id','status');
    }

    public function item_active(){
        return $this->belongsToMany('App\product')->wherePivot('status', 'ACTIVE')->orderby('product_id','ASC');
    }
}
