<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable= [
        'cc',
        'symbol',
        'name','exchange_rate','is_active'
    ];
}
