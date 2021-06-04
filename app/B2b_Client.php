<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class B2b_Client extends Model
{
    protected $table = "b2b_client";

    protected $fillable = [
        'client_name', 
        'client_slug', 
        'company_name',
        'client_address',
        'status',
        'created_at',
        'updated_at'
    ];
}
