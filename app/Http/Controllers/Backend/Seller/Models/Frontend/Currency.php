<?php

namespace App\Models\Frontend;

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
