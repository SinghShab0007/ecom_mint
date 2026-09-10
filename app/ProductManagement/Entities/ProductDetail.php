<?php

namespace App\Modules\Backend\ProductManagement\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'product_id', 'is_free_shipping', 'is_flash_deal', 'is_flat_rate', 'is_product_wise_shipping', 'is_quantity_multiply', 'warning_quantity', 'is_show_stock_quantity', 'is_show_stock_with_text_only', 'is_hide_stock', 'is_cash_on_delivery', 'is_featured', 'is_best_sell', 'is_todays_deal', 'flash_deal_title', 'flash_deal_discount', 'flash_deal_discount_type', 'inside_shipping_days', 'outside_shipping_days', 'vat', 'tax',
    ];
}
