<?php

namespace App\Modules\Backend\PromotionManagement\Entities;

use App\Modules\Backend\ProductManagement\Entities\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromotionalProduct extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'promotions';
    protected $fillable = [
        'product_id', 'title','label', 'position', 'image', 'promotion_price', 'expire_at','total_viewed',
        'is_active', 'is_approve'
    ];

    public function product():HasOne
    {
        return $this->hasOne(Product::class, 'id', 'product_id')->withDefault([
            'name' => ''
        ]);
    }
}
