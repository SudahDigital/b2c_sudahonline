<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spv_sales extends Model
{
    protected $table = 'spv_sales';
    protected $fillable = ['spv_id', 
                            'sls_id',
                            'status',
                            'created_at',
                            'updated_at'
                          ];
}
