<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponUsage extends Model
{
    use HasFactory;

    protected $hidden = ['created_at','updated_at','deleted_at'];
    protected $fillable = ['user_id','coupon_id'];
}
