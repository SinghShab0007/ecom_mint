<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBilling extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','first_name','last_name','address_1','post_code','user_city','country_id','mobile','email','is_active'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
