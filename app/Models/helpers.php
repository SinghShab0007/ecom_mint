<?php

use App\Models\Category;
use App\Models\Settings;
use App\Models\Frontend\Message;
use Illuminate\Support\Facades\Date;
use Illuminate\Database\Eloquent\Collection;

/**
 * Display categories as menu items on top from storage
 *
 * @return Collection
 */
function menus(): Collection
{
    $menus = Category::query()
        ->where('parent',0)
        ->with('subCategories')
        ->where('status',1)
        ->get();

    return $menus;
}

/**
 * Display currency symbol with amount
 *
 * @param $amount
 * @return string
 */
function currency($amount,$decimal = 0): string
{
    $settings = Settings::query()->first();
    $symbol = $settings->currency->symbol;
    return $symbol.number_format($amount,$decimal);
}

function messages($seller,$customer)
{
    $messages = Message::query()
        ->where('seller_id',$seller)
        ->where('customer_id',$customer)
        ->get();

    return $messages;
}

if (!function_exists('formatted_date')) {
    function formatted_date(string $date = null, string $format = 'd M, Y'): ?string
    {
        return !empty($date) ? Date::parse($date)->format($format) : null;
    }
}