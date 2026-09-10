<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $table = 'sizes';

    protected $fillable= [
        'name',
        'display_in_search',
        'is_active',
    ];
}
