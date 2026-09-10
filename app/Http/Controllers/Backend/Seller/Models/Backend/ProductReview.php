<?php

namespace App\Models\Backend;

use App\Modules\Backend\CustomerManagement\Entities\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Backend\ProductManagement\Entities\Product;

class ProductReview extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id', 'review_point', 'review_note', 'user_id', 'is_active', 'publish_stat'
    ];

    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'id');
    }
}
