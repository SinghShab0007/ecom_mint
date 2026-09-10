<?php

namespace App\Modules\Backend\ProductManagement\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVideo extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'video_provider',
        'video_link', 'created_by'
    ];
}
