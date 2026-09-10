<?php

namespace App\Modules\Backend\OrderManagement\Entities;

use App\Models\Backend\Country;
use App\Models\Backend\Currency;
use App\Modules\Backend\CustomerManagement\Entities\Customer;
use App\Modules\Backend\SellerManagement\Entities\Seller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;


    protected $fillable = [
        'order_no',
        'discount',
        'tax',
        'shipping_cost',
        'total_price',
        'currency_id',
        'exchange_rate',
        'shipping_name',
        'shipping_address_1',
        'shipping_address_2',
        'shipping_mobile',
        'shipping_email',
        'shipping_post',
        'shipping_town',
        'shipping_country_id',
        'shipping_note',
        'payment_by',
        'user_id',
        'user_first_name',
        'user_last_name',
        'user_address_1',
        'user_post_code',
        'user_city',
        'user_country_id',
        'user_mobile',
        'user_email',
    ];

    public function full_name()
    {
        return ucfirst($this->user_first_name) . ' ' . ucfirst($this->user_last_name);
    }

    /* order details */

    public function details(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    /* order status */

    public function orderStatus(): HasOne
    {
        return $this->hasOne(OrderStatus::class, 'id', 'order_stat')->withDefault(['name' => '']);
    }

    /* order payment*/

    public function payment(): HasOne
    {
        return $this->hasOne(OrderPayment::class, 'order_id')->withDefault([]);
    }

    /* customer order */

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'id', 'user_id')->withDefault(['full_name' => '']);
    }

    public function country(): HasOne
    {
        return $this->hasOne(Country::class, 'id', 'user_country')->withDefault(['name' => '']);
    }

    public function productPriceWithCurrency()
    {
        $amount = $this->total_price * $this->exchange_rate;
        $currency = Currency::find($this->currency_id);
        $symbol = $currency->cc ?? '৳';
        return $symbol . ' ' . number_format($amount, 2);
    }

    public function costWithCurrency()
    {
        $amount = $this->shipping_cost;
        $currency = Currency::find($this->currency_id);
        $symbol = $currency->cc ?? '৳';
        return $symbol . ' ' . number_format($amount, 2);
    }

    public function totalWithCurrency()
    {
        $amount = $this->shipping_cost + ($this->total_price * $this->exchange_rate);
        $currency = Currency::find($this->currency_id);
        $symbol = $currency->cc ?? '৳';
        return $symbol . ' ' . number_format($amount, 2);
    }

    public function currency()
    {
        $currency = Currency::find($this->currency_id);
        $symbol = $currency->symbol;
        return $symbol;
    }

}
