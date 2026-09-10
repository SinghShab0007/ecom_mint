<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = ['product_id','title','label','position','image','expire_at','total_viewed','promotion_price','is_active','is_approve'];
}
