<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable= [
        'cc',
        'symbol',
        'name',
        'exchange_rate'
    ];
}
