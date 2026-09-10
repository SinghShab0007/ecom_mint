<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'is_free_shipping', 'is_flash_deal', 'is_flat_rate', 'is_product_wise_shipping', 'is_quantity_multiply', 'warning_quantity', 'is_show_stock_quantity', 'is_show_stock_with_text_only', 'is_hide_stock', 'is_cash_on_delivery', 'is_featured', 'is_todays_deal', 'is_best_sell', 'flash_deal_title', 'flash_deal_discount','flash_deal_discount_type', 'inside_shipping_days', 'outside_shipping_days', 'vat', 'tax'];
}
