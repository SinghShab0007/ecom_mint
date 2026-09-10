<?php

namespace App\Models\Seller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = ['seller_id','user_id','order_id','order_stat','product_id','color','size','sale_price','qty','discount','shipping_cost','total_shipping_cost','total_price','grand_total','tax','currency_id','exchange_rate'];
}
