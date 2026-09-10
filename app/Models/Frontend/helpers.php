<?php

use App\Models\Option;
use App\Models\Frontend\Menu;
use App\Models\Frontend\Header;
use App\Models\Frontend\Message;
use App\Models\Frontend\Product;
use App\Models\Backend\Wholesale;
use App\Models\Frontend\Category;
use App\Models\Frontend\Currency;
use App\Models\Frontend\Language;
use App\Models\Frontend\Wishlist;
use App\Models\Frontend\Promotion;
use App\Models\Frontend\OrderDetail;
use App\Models\Frontend\OrderStatus;
use App\Models\Frontend\ProductReview;
use Illuminate\Support\Facades\Cookie;
use App\Models\Frontend\PaymentGateway;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Add class(es) to active menu item
 *
 * @param $path
 * @param string $active
 * @return string
 */
function isActiveMenu($path, string $active = 'active'): string
{
    return call_user_func_array('Request::is', (array)$path) ? $active : '';
}

function cache_remember(string $key, callable $callback, int $ttl = 1800): mixed {
    return cache()->remember($key, env('CACHE_LIFETIME', $ttl), $callback);
}

function getContactsInfos() {
    return Option::where('key', 'contact-infos')->latest()->get();
    // return cache_remember('contact-infos', function () {

    // });
}

/**
 * Site appearance information
 *
 * @param $key
 * @return mixed
 */
function maanAppearance($key)
{
    $path = Storage::get('maanAppearance.json');

    $json = json_decode($path);

    return $json->$key;
}

/**
 * Display header items
 *
 * @param $col
 * @return bool
 */
function maanHeader($col): bool
{
    return Header::query()->where($col,1)->exists();
}

/**
 * Display categories as menu items on top from storage
 *
 * @return Collection
 */
function menus(): Collection
{
    $menus = Category::query()
        ->with('subCategories.subCategories')
        ->whereNull('category_id')
        ->where('is_active', 1)
        ->orderBy('order')
        ->take(10)
        ->get();

    return $menus;
}

function menubars(): Collection
{
    $menubars = Category::query()
        ->where('is_active', 1)
        ->where('for_menu', 1)
        ->orderBy('order')
        ->take(10)
        ->get();

    return $menubars;
}

/**
 * Page menu from storage
 *
 * @param $position
 * @return array|Builder[]|Collection
 */
function maanMenus($position)
{
    if($position == 1){
        $menus = Menu::query()
            ->where('is_header_menu',1)
            ->get();
    }elseif($position == 2){
        $menus = Menu::query()
            ->where('is_footer_menu',1)
            ->where('is_quick_link',1)
            ->get();
    }elseif($position == 3){
        $menus = Menu::query()
            ->where('is_footer_menu',1)
            ->where('is_informatics',1)
            ->get();
    }else{
        $menus = [];
    }

    return $menus;
}

/**
 * Display list of currencies from database
 *
 * @return Collection
 */
function currencies(): Collection
{
    return Currency::query()->where('is_active',1)->get();
}

/**
 * Display currency settings from user cookie
 *
 * @param $key
 * @return mixed
 */
function userCurrency($key)
{
    $currency = json_decode(Cookie::get('currency'));

    if($currency == null){
        $id = maanAppearance('currency_id');
        $currency = Currency::query()->findOrFail($id);

        $data = [
            'id' => $currency->id,
            'symbol' => $currency->symbol,
            'name' => $currency->name,
            'cc' => $currency->cc,
            'exchange_rate' => $currency->exchange_rate,
        ];
        Cookie::queue(Cookie::make('currency', json_encode($data)));
    }

    return $currency->$key;
}

function currencyRaw($amount, $id, $ex_rate, int $decimal = 0)
{
    $amount = $amount * $ex_rate;
    $currency = Currency::where('cc', 'INR')->first();
    $symbol = $currency ? ($currency->symbol ?? '₹') : '₹';
    return $symbol . number_format($amount, $decimal);
}

/**
 * Display currency symbol with amount from order table
 *
 * @param $id
 * @param $amount
 * @param int $decimal
 * @return string
 */
function orderCurrency($id, $amount, int $decimal = 0): string
{
    $isExists = Currency::query()->where('id',$id)->exists();

    if ($isExists) {
        $currency = Currency::query()->findOrFail($id);
        $symbol = $currency->symbol ?? '₹';
    } else {
        $symbol = '₹';
    }

    return $symbol . number_format($amount, $decimal);
}

/**
 * Display currency symbol with amount
 *
 * @param $amount
 * @param int $decimal
 * @return string
 */
function currency($amount, int $decimal = 0): string
{
    if (Cookie::has('currency')) {
        $c = json_decode(Cookie::get('currency'));
        $symbol = $c->symbol ?? '₹';
        $amount = ($c->exchange_rate ?? 1) * floatval($amount);
    } else {
        $currency = Currency::where('cc', 'INR')->first();
        if ($currency) {
            $data = [
                'id' => $currency->id,
                'symbol' => $currency->symbol ?? '₹',
                'name' => $currency->name,
                'cc' => $currency->cc,
                'exchange_rate' => $currency->exchange_rate,
            ];
            Cookie::queue(Cookie::make('currency', json_encode($data)));
            $symbol = $currency->symbol ?? '₹';
            $amount = $currency->exchange_rate * floatval($amount);
        } else {
            $symbol = '₹';
            $amount = floatval($amount);
        }
    }
    return $symbol . number_format($amount, $decimal);
}

function bdtSymble()
{
    if (Cookie::has('bdtSymble')) {
        $c = json_decode(Cookie::get('bdtSymble'));
        $symbol = $c->symbol ?? '₹';
    } else {
        $currency = Currency::where('cc', 'INR')->first();
        if ($currency) {
            $data = [
                'id' => $currency->id,
                'symbol' => $currency->symbol,
                'name' => $currency->name,
                'cc' => $currency->cc,
                'exchange_rate' => $currency->exchange_rate,
            ];
            Cookie::queue(Cookie::make('bdtSymble', json_encode($data)));
            $symbol = $currency->symbol ?? '₹';
        } else {
            $symbol = '₹';
        }
    }
    return $symbol;
}

/**
 * Count wishlist items for authenticated customer
 *
 * @return int
 */
function wishlistCount(): int
{
    if(auth('customer')->check()){
        return Wishlist::query()->where('user_id',auth('customer')->id())->count();
    }else{
        return 0;
    }
}

/**
 * Display total queried product quantity
 *
 * @param $key
 * @param $value
 * @return int
 */
function productCount($key,$value): int
{
    return Product::query()->whereBetween($key,$value)->count();
}

/**
 * Display product rating in product card
 *
 * @param $id
 * @return float|int
 */
function productRating($reviews)
{
    $rating = $reviews->sum('review_point') && $reviews->count() ? $reviews->sum('review_point') / $reviews->count() : 0;

    return $rating;
}

/**
 * Retrieve order status
 *
 * @param $id
 * @return string
 */
function orderStatus($id): string
{
    $o = OrderStatus::query()->findOrFail($id);
    return $o->name;
}

/**
 * Add css class to order status button
 *
 * @param $id
 * @return string
 */
function orderButtonClass($id): string
{
    if($id == 2){
        return 'approved-btn';
    }elseif($id == 5){
        return 'shipped-btn';
    }elseif($id == 6){
        return 'delivered-btn';
    }else{
        return 'cancel-btn';
    }
}

/**
 * Display brand logo
 *
 * @param $filename
 * @return string
 */
function brandLogo($filename): string
{
    $url = config('constants.image_base_path')."/brands/120x80/".$filename;

    $ch = curl_init();
    $timeout = 0;
    curl_setopt ($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

    // Getting binary data
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_exec($ch);
    curl_close($ch);

    // Getting status code of curl request
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if($status != 200){
        $url = config('constants.image_base_path').'/brands/120x80/default.png';
    }

    return $url;
}

/**
 * Calculate total number of orders
 *
 * @param int $stat
 * @return int
 */
function orderCount(int $stat=0): int
{
    $orders = OrderDetail::query()->where('user_id',auth('customer')->id());

    if($stat > 0){
        $orders->where('order_stat',$stat);
    }

    return $orders->count();
}

/**
 * Display user gender
 *
 * @param $id
 * @return string
 */
function userGender($id): string
{
    if($id == 1){
        return 'Male';
    }elseif($id == 2){
        return 'Female';
    }else{
        return 'Others';
    }
}

/**
 * Check if a product has promotion
 *
 * @param $product
 * @return bool
 */
function hasPromotion($product): bool
{
    return Promotion::query()->where('product_id',$product)
        ->where(function($q){
            $q->where('expire_at','>',now())->orWhere('expire_at',null);
        })
        ->where('is_active',1)
        ->where('is_approve',1)
        ->exists();
}

/**
 * Display promotion price
 */
function promotionPrice($product)
{
    $p = Promotion::query()->where('product_id',$product)
        ->where(function($q){
            $q->where('expire_at','>',now())->orWhere('expire_at',null);
        })
        ->where('is_active',1)
        ->where('is_approve',1)
        ->latest()
        ->first();

    return $p->promotion_price;
}
/**
 * Check if a product has wholesale
 *
 * @param $product
 * @return bool
 */
function hasWholesale($product): bool
{
    return Wholesale::query()->where('product_id',Product::where('id',$product)->where('wholesale_status',1)->value('id'))
        ->where('status',1)
        ->exists();
}
/**
 * Display wholesale price
 */
function wholdesalePrice($product, $quantity)
{
    $wholesales = Wholesale::where('product_id',$product)
        ->where('status',1)
        ->get();
    foreach ( $wholesales as $index=>$wholesale) {
        if ($index==0 && $quantity<$wholesale->min_range){
            return Product::where('id',$wholesale->product_id)->value('sale_price');
        }else{
            if ($quantity>=$wholesale->min_range && $quantity<=$wholesale->max_range){
                return $wholesale->price ;
            }
        }
    }

}

/**
 * Validate a user for review
 *
 * @param $user
 * @param $product
 * @return bool
 */
function canReview($user,$product): bool
{
    $isReview = ProductReview::query()
        ->where('user_id',$user)
        ->where('product_id',$product);
    $isExists=$isReview->exists();
    $reviewCount=$isReview->count();

    $isOrder = OrderDetail::query()
        ->where('product_id',$product)
        ->where('user_id',$user);
    $eligible = $isOrder->exists();
    $orderCount = $isOrder->count();

    if($isExists && $reviewCount==$orderCount){
        return false;
    }

    return $eligible;

}

function uniBoxSuggestions()
{
    return Product::query()
        ->with('images')
        ->orderByDesc('total_viewed')
        ->take(2)
        ->get();
}

/**
 * Get the payment gateway status
 *
 * @param $provider
 * @return bool
 */
function gatewayOn($provider): bool
{
    $gateway = PaymentGateway::query()->where('name',$provider)->first();

    return $gateway->status == 1 ? true : false;
}

/**
 * Display a list active language list
 *
 * @return Collection
 */
function languages(): Collection
{
    return Language::query()->where('is_active',1)->get();
}

function lang($key)
{
    $lang = json_decode(Cookie::get('language'));

    if(!$lang){
        $lang = Language::query()->where('default',1)->first();
    }

    return $lang->$key;
}

function messages($seller,$customer)
{
    $messages = Message::query()
        ->where('seller_id',$seller)
        ->where('user_id',$customer)
        ->get();

    return $messages;
}

/**
 * Deterministic accent colour for a blog post.
 *
 * Blog cards show a solid colour panel instead of a cover image. Deriving the
 * colour from the post id (falling back to the slug) keeps it stable across
 * page loads and pagination - a random colour would flicker on every request.
 *
 * @param  mixed  $blog  Blog model, or any id/string key.
 * @return string Hex colour, dark enough to carry white text.
 */
function blogColor($blog): string
{
    $palette = [
        '#4C1D6B', // brand plum
        '#1B3A5C', // deep navy
        '#0F5257', // teal
        '#7A2E4A', // wine
        '#8A4B08', // burnt amber
        '#14532D', // forest
        '#3F3D56', // slate violet
        '#7C2D12', // rust
    ];

    if (is_object($blog)) {
        $key = $blog->id ?? $blog->slug ?? $blog->title ?? '';
    } else {
        $key = $blog;
    }

    $index = is_numeric($key)
        ? (int) $key
        : crc32((string) $key);

    return $palette[abs($index) % count($palette)];
}

/**
 * Monogram shown on a blog's colour panel so the block reads as deliberate
 * rather than as a failed image load.
 */
function blogInitial($blog): string
{
    $title = is_object($blog) ? ($blog->title ?? '') : (string) $blog;
    $title = trim(strip_tags((string) $title));

    return $title === '' ? '#' : mb_strtoupper(mb_substr($title, 0, 1));
}
