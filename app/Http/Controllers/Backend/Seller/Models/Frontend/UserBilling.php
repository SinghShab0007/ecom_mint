<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBilling extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','first_name','last_name','address_1','post_code','user_city','country_id','mobile','email','is_active'];
}
