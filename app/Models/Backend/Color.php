<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable= [
        'name',
        'hex',
        'display_in_search',
        'is_active',
    ];
}
