<?php

namespace App\Models\Frontend;

class CartItem
{
    /**
     * @param $id
     * @return string
     */
    public static function name($id): string
    {
        $product = Product::query()->findOrNew($id);
        return $product->name ?? 'undefined';
    }

    /**
     * @param $id
     * @return string
     */
    public static function thumbnail($id): string
    {
        $product = Product::query()->findOrNew($id);
        return $product->images->first()->image ?? '';
    }

    /**
     * @param $id
     * @return string
     */
    public static function estimatedShippingDays($id): string
    {
        $product = Product::query()->findOrNew($id);
        return $product->details->inside_shipping_days ?? '3 to 7 days';
    }

    /**
     * @param $id
     * @param $quantity
     * @return int
     */
    public static function price($id, $quantity = 1): int
    {
        $product = Product::query()->findOrFail($id);
        if(hasPromotion($id)){
            $price = promotionPrice($id);
        }else{
            if (hasWholesale($id)){
                $price= wholdesalePrice($id,$quantity);
            }else{
                $price = $product->sale_price;
            }
        }

        return $price * $quantity;
    }

    public static function shipping($id, $quantity = 1)
    {
        $product = Product::query()->findOrFail($id);

        if($product->details->is_free_shipping == 0){
            $value = ($product->shipping_cost * $quantity);
        }else{
            $value = 0;
        }

        return $value;
    }
}
