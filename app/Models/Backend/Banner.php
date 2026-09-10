<?php

namespace App\Models\Backend;

use App\Modules\Backend\ProductManagement\Entities\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'banners';

    protected $fillable = [
        'category_id',
        'title',
        'sub_title',
        'offer_title',
        'image',
        'target',
        'type',
        'description',
        'expire_at',
        'is_active',
        'publish_stat',
        'total_click',
    ];

    public function category(): HasOne {
        return $this->hasOne(Category::class,'id','category_id');
    }
}
