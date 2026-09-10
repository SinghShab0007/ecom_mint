<?php

namespace App\Modules\Backend\OrderManagement\Entities;

use App\Models\Backend\Currency;
use App\Modules\Backend\ProductManagement\Entities\Product;
use App\Modules\Backend\SellerManagement\Entities\Seller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id','user_id','order_id','order_stat','product_id','sale_price','color','size','qty','discount','tax',
        'shipping_cost','total_shipping_cost','total_price','grand_total','currency_id','exchange_rate','inside_shipping_days', 'outside_shipping_days'
    ];

    public function order() : BelongsTo
    {
        return $this->belongsTo(Order::class,'order_id');
    }

    public function product() :BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id')->withTrashed();
    }
    /* order of seller */

    public function seller() :BelongsTo
    {
        return $this->belongsTo(Seller::class, 'seller_id')->withDefault(['full_name' => '']);
    }

    /* order status */

    public function orderStatus() :HasOne
    {
        return $this->hasOne(OrderStatus::class, 'id', 'order_stat')->withDefault(['name' => '']);
    }

    /* order p

    /* order of seller */

    public function timelines(): HasMany
    {
        return $this->hasMany(Timeline::class, 'order_detail_id')->orderBy('order_stat_datetime','Desc');
    }


    public function shippingWithCurrency()
    {
        $amount = $this->total_shipping_cost;
        $currency = Currency::find($this->currency_id);
        $symbol = $currency->cc ?? '৳';
        return $symbol.' '.number_format($amount,2);
    }

}
