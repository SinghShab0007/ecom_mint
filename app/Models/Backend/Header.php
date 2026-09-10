<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Header extends Model
{
    use HasFactory;

    protected $fillable=[
        'show_language','show_currency','enable_sticky_header','enable_tracking_order','show_help'
    ];
}
