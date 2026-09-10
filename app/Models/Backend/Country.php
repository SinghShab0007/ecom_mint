<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

    protected $fillable= [
        'name',
        'nice_name',
        'iso_no',
        'iso3_no',
        'num_code',
        'phone_code',
        'is_active',
    ];
}
