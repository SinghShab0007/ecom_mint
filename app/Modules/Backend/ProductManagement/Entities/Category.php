<?php

namespace App\Modules\Backend\ProductManagement\Entities;

use App\Models\Backend\Banner;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'category_id',
        'order',
        'icon',
        'banner',
        'meta_title',
        'meta_description',
        'slug',
        'for_menu',
        'commission_rate',
        'show_in_home',
        'is_active',

    ];

    public function parents() : HasOne
    {
        return $this->hasOne(self::class, 'id', 'category_id');
    }
    public function banners(): BelongsTo
    {
        return $this->belongsTo(Banner::class, 'category_id', 'id');
    }

}
