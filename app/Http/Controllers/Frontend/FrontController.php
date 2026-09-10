<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Wholesale;
use App\Models\Frontend\Brand;
use App\Models\Frontend\Category;
use App\Models\Frontend\Color;
use App\Models\Frontend\ContactQuery;
use App\Models\Frontend\Currency;
use App\Models\Frontend\EmailSubscriber;
use App\Models\Frontend\Language;
use App\Models\Frontend\Menu;
use App\Models\Frontend\Message;
use App\Models\Frontend\Notice;
use App\Models\Frontend\Product;
use App\Models\Frontend\Banner;
use App\Models\Frontend\ProductReview;
use App\Models\Frontend\Promotion;
use App\Models\Frontend\Seller;
use App\Models\Frontend\Size;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class FrontController extends Controller
{
    /** Max products shown per category section on home (`_products` partial). */
    private const HOME_CATEGORY_PRODUCT_LIMIT = 16;

    /** Total product slots across all category sections on home. */
    private const HOME_PAGE_CATEGORY_PRODUCTS_TOTAL_CAP = 200;

    /** Products per tab in `_product-tab` (All item, New Arrivals, Best Seller, etc.). */
    private const HOME_PRODUCT_TAB_LIMIT = 150;

    /** Similar products block on product detail page. */
    private const PRODUCT_DETAIL_SIMILAR_LIMIT = 30;

    /**
     * Display landing page
     *
     * @return View
     */
    public function index(): View
    {
        $brands = Brand::query()
            ->active()
            ->orderBy('order')
            ->take(20)
            ->get();

        /** Category collection section */
        $categories = $this->categories();

        /** One home section per top-level category (see `_products` partial). */
        $shopCategories = $this->homeCategorySections();

        /** Promotion Position One */
        $bannerAds = Promotion::query()
            ->with('product.images', 'product.reviews')
            ->eligible()
            ->where('position', 1)
            ->orderByDesc('id')
            ->take(4)
            ->get();

        /** Promotion Position Two */
        // $discounts = Promotion::query()
        //     ->eligible()
        //     ->where('position', 2)
        //     ->orderByDesc('id')
        //     ->take(3)
        //     ->get();

        /** Promotion Position Three */
        $adPoster = Promotion::query()
            ->eligible()
            ->where('position', 3)
            ->orderByDesc('id')
            ->first();

        /** Promotion Position Four */
        $offer = Promotion::query()
            ->eligible()
            ->where('position', 4)
            ->orderByDesc('id')
            ->first();

        /** promotional slider contents queries */
        $banners = Banner::query()
            ->with('category')
            ->where('is_active', 1)
            ->where('publish_stat', 1)
            ->where(function ($q) {
                $q->where('expire_at', '>', now())->orWhere('expire_at', null);
            })
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        /** "Deal of the week" tabs (`_product-tab`): up to HOME_PRODUCT_TAB_LIMIT active products per tab */
        $allProducts = Product::query()
            ->with('images', 'details', 'reviews')
            ->active()
            ->inRandomOrder()
            ->take(self::HOME_PRODUCT_TAB_LIMIT)
            ->get();

        $newArrivals = Product::query()
            ->with('images', 'details', 'reviews')
            ->active()
            ->orderByDesc('created_at')
            ->take(self::HOME_PRODUCT_TAB_LIMIT)
            ->get();

        $bestSellers = Product::query()
            ->with('images', 'details', 'reviews')
            ->active()
            ->inRandomOrder()
            ->take(self::HOME_PRODUCT_TAB_LIMIT)
            ->get();

        $featureProducts = Product::query()
            ->with('images', 'details', 'reviews')
            ->active()
            ->whereHas('details', function ($q) {
                $q->where('is_featured', 1);
            })
            ->inRandomOrder()
            ->take(self::HOME_PRODUCT_TAB_LIMIT)
            ->get();

        $trends = Product::query()
            ->with('images', 'details', 'reviews')
            ->active()
            ->inRandomOrder()
            ->take(self::HOME_PRODUCT_TAB_LIMIT)
            ->get();
        /** Deal of the week tabs end */

        $notice = Notice::query()
            ->where('published_at', '<', now())
            ->where('is_active', 1)
            ->latest()
            ->first();

        $homeCategoryProductLimit = self::HOME_CATEGORY_PRODUCT_LIMIT;
        $homeCategoryProductsTotalCap = self::HOME_PAGE_CATEGORY_PRODUCTS_TOTAL_CAP;

        return view('frontend.index', compact(
            'categories',
            'shopCategories',
            'allProducts',
            'newArrivals',
            'bestSellers',
            'featureProducts',
            'trends',
            'brands',
            'banners',
            'adPoster',
            'bannerAds',
            'offer',
            'notice',
            'homeCategoryProductLimit',
            'homeCategoryProductsTotalCap'
        ));
    }

    /**
     * Build the home page's per-category sections.
     *
     * Products are attached to leaf categories ("T-Shirts"), never to the
     * top-level ones ("Men's Fashion"), so a plain `hasMany` on a root category
     * returns nothing. Each root therefore aggregates the products of its whole
     * subtree, which is what makes the section render at all.
     *
     * @return \Illuminate\Support\Collection<int, Category>
     */
    private function homeCategorySections()
    {
        $categories = Category::query()
            ->where('is_active', 1)
            ->orderBy('order')
            ->get(['id', 'category_id', 'name', 'slug', 'order', 'show_in_home']);

        // child id => [child ids], so a subtree can be walked without recursion in SQL.
        $childrenOf = $categories->groupBy(fn ($c) => (int) ($c->category_id ?? 0));

        $descendantIds = function (int $id) use (&$descendantIds, $childrenOf): array {
            $ids = [$id];
            foreach ($childrenOf->get($id, collect()) as $child) {
                $ids = array_merge($ids, $descendantIds((int) $child->id));
            }
            return $ids;
        };

        $roots = $childrenOf->get(0, collect())->where('show_in_home', 1);

        return $roots->map(function (Category $root) use ($descendantIds) {
            $products = Product::query()
                ->active()
                ->with('images', 'details')
                ->whereIn('category_id', $descendantIds((int) $root->id))
                ->latest('id')
                ->take(self::HOME_CATEGORY_PRODUCT_LIMIT)
                ->get();

            // The partial reads $category->products, so hand it the aggregate.
            $root->setRelation('products', $products);

            return $root;
        })->filter(fn (Category $c) => $c->products->isNotEmpty())->values();
    }

    public function shop(Request $request)
    {
        $q = trim((string) $request->get('q'));

        $products = Product::query()
            ->where('is_active', 1)
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('tags', 'like', "%{$q}%")
                        ->orWhere('sku', 'like', "%{$q}%");
                });
            })
            ->orderByRaw('quantity = 0, quantity')
            ->latest()
            ->paginate(24)
            ->withQueryString();

        $categories = $this->categories();

        $brands = Brand::query()
            ->where('is_active', 1)
            ->orderBy('order')
            ->has('products')
            //->take(7)
            ->get();

        $sellers = Seller::query()
            ->where('is_active', 1)
            ->where('is_suspended', 0)
            ->has('products')
            ->get();

        $sizes = Size::query()->where('is_active', 1)->get();

        $colors = Color::query()
            ->where('is_active', 1)
            ->where('display_in_search', 1)
            ->get();

        $prices = collect(['min' => 0, 'max' => 5000, 'values' => [75, 1000]]);

        $populars = Product::query()->inRandomOrder()->take(4)->get();

        return view('frontend.pages.shop', compact('products', 'categories', 'sizes', 'colors', 'prices', 'populars', 'brands', 'sellers'));
    }

    public function bannerProduct($id)
    {
        $banner = Banner::query()->findOrFail($id);

        if (!Cookie::has('total_click-' . $id)) {
            $banner->increment('total_click');
            Cookie::queue(Cookie::forever('total_click-' . $id, 'clicked'));
        }

        if ($banner->product_id == 1) {
            return $this->product($banner->product->slug);
        }

        if ($banner->brand_id == 1) {
            return $this->brand($banner->brand->slug);
        }

        if ($banner->category_id == 1) {
            return $this->category($banner->category->slug);
        }
    }

    /**
     * Display individual brand page
     *
     * @param $slug
     * @return View
     */
    public function brand($slug): View
    {
        $categories = $this->categories();

        $brands = Brand::query()
            ->where('is_active', 1)
            ->orderBy('order')
            ->has('products')
            ->take(7)
            ->get();

        $brand = Brand::query()
            ->where('slug', $slug)
            ->firstOr(function () {
                abort(404);
            });

        $title = $brand->name;

        $sellers = Seller::query()
            ->where('is_active', 1)
            ->where('is_suspended', 0)
            ->has('products')
            ->get();

        $sizes = Size::query()->where('is_active', 1)->get();

        $colors = Color::query()
            ->where('is_active', 1)
            ->where('display_in_search', 1)
            ->get();

        $prices = collect(['min' => 0, 'max' => 5000, 'values' => [75, 1000]]);

        $products = Product::query()->active()->where('brand_id', $brand->id)->paginate(24);

        $populars = Product::query()->inRandomOrder()->take(4)->get();

        return view('frontend.pages.shop', compact('title', 'brand', 'categories', 'brands', 'sellers', 'sizes', 'colors', 'prices', 'populars', 'products'));
    }

    public function category($slug)
    {
        $categories = $this->categories();

        $category = Category::query()
            ->where('slug', $slug)
            ->firstOr(function () {
                abort(404);
            });

        $title = $category->name;

        $brands = Brand::query()
            ->where('is_active', 1)
            ->orderBy('order')
            ->has('products')
            //->take(7)
            ->get();

        $sellers = Seller::query()
            ->where('is_active', 1)
            ->where('is_suspended', 0)
            ->has('products')
            ->get();

        $populars = Product::query()->inRandomOrder()->take(4)->get();

        $cats[] = $category->id;
        foreach ($category->subCategories as $category) {
            $cats[] = $category->id;
            foreach ($category->subCategories as $category) {
                $cats[] = $category->id;
            }
        }

        $products = Product::query()
            ->whereIn('category_id', $cats)
            ->where('is_active', 1)
            ->paginate(24);

        $sizes = Size::query()->where('is_active', 1)->get();

        $colors = Color::query()
            ->where('is_active', 1)
            ->where('display_in_search', 1)
            ->get();

        $prices = collect(['min' => 0, 'max' => 5000, 'values' => [75, 1000]]);

        return view('frontend.pages.shop', compact('title', 'category', 'categories', 'sizes', 'colors', 'prices', 'populars', 'products', 'brands', 'sellers'));
    }

    public function product($slug)
    {
        $product = Product::query()
            ->where('slug', $slug)
            ->with(
                'images',
                'reviews',
                'details',
                'seller',
                'category',
                'brand',
                'productstock.color',
                'productstock.size',
                'colors',
                'sizes',
                'video'
            )
            ->firstOrFail();

        $product->increment('total_viewed');

        $rating = productRating($product->reviews);

        $pendingReview = ProductReview::query()
            ->where('publish_stat', NULL)
            ->where('product_id', $product->id)
            ->where('user_id', auth('customer')->id())
            ->exists();

        $similarProducts = Product::query()
            ->with('images', 'reviews')
            ->active()
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(self::PRODUCT_DETAIL_SIMILAR_LIMIT)
            ->get();
        $wholesales = Wholesale::where('product_id', $product->id)->where('status', 1)->get();
        return view('frontend.pages.product-details', compact('product', 'rating', 'similarProducts', 'pendingReview', 'wholesales'));
    }

    /**
     * Display shopping cart page
     *
     * @return View
     */
    /**
     * Cart page - the step between the product page and checkout.
     */
    public function cart(): View
    {
        $carts = json_decode(Cookie::get('cart', ''));

        return view('frontend.pages.cart', compact('carts'));
    }

    /**
     * Display cancel message
     *
     * @return View
     */
    public function paymentCancel(): View
    {
        $msg = trans('Alas! Unable to process payment.');
        return view('frontend.pages.payment-cancel', compact('msg'));
    }

    public function page($url)
    {
        if (in_array($url, ['new-arrivals', 'trends'], true)) {
            return redirect()->to(url('/shop'));
        }

        if ($url === 'about-us') {
            return view('frontend.pages.about-us');
        }

        if($url=== 'contact'){
            return view('frontend.pages.contact');
        }

        if($url === 'privacy-n-policy'){
            return view('frontend.pages.privacy-policy');
        }


        if($url === 'terms-and-conditions'){
            return view('frontend.pages.terms-and-conditions');
        }


        if($url === 'cancellation-policy' || $url === 'return-policy'){
            return view('frontend.pages.cancellation-policy');
        }

        if($url === 'shipping-policy'){
            return view('frontend.pages.shipping-policy');
        }

        if($url === 'dispute-grievance-policy' || $url === 'grievance-redressal'){
            return view('frontend.pages.dispute-grievance-policy');
        }
         



        $menu = Menu::query()->where('url', 'like', '%' . $url . '%')->first();

        if (!$menu) {
            return view('frontend.errors.404');
        }

        $page = $menu->page;

        if (!$page) {
            return view('frontend.errors.404');
        }

        return view('frontend.pages.blank', compact('page'));
    }

    /**
     * Store a contact form query
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function contactStore(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'    => ['required', 'string', 'max:100'],
            'email'   => ['required', 'email', 'max:100'],
            'phone'   => ['nullable', 'string', 'max:20'],
            'subject' => ['nullable', 'string', 'max:120'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $data['ip_address'] = $request->ip();

        ContactQuery::create($data);

        return redirect()
            ->to(url('page/contact') . '#contact-form')
            ->with('contact_success', 'Thank you! Your query has been submitted successfully. Our team will get back to you shortly.');
    }

    public function dealOfTheWeek(Request $request)
    {
        $tab = $request->get('tab');

        if ($tab == 'trends') {
            $products = Product::query()->inRandomOrder()->take(6)->get();
        } elseif ($tab == 'new-arrivals') {
            $products = Product::query()
                ->where('is_active', 1)
                ->orderByDesc('created_at')
                ->take(6)
                ->get();
        } elseif ($tab == 'best-seller') {
            $products = Product::query()
                ->where('is_active', 1)
                ->inRandomOrder()
                ->take(6)
                ->get();
        } elseif ($tab == 'our-featured') {
            $products = Product::query()
                ->whereHas('details', function ($q) {
                    $q->where('is_featured', 1);
                })
                ->inRandomOrder()
                ->take(6)
                ->get();
        } else {
            $products = Product::query()
                ->where('is_active', 1)
                ->inRandomOrder()
                ->take(6)
                ->get();
        }

        return view('frontend.pages._ajax-deal-of-the-week-products', compact('products'));
    }

    public function bestSelling()
    {
        $title = 'Best Selling';

        $categories = $this->categories();

        $brands = Brand::query()
            ->where('is_active', 1)
            ->orderBy('order')
            ->has('products')
            ->take(7)
            ->get();

        $sellers = Seller::query()
            ->where('is_active', 1)
            ->where('is_suspended', 0)
            ->has('products')
            ->get();

        $populars = Product::query()->inRandomOrder()->take(4)->get();

        $products = Product::query()
            ->active()
            ->whereHas('details', function ($q) {
                $q->where('is_best_sell', 1);
            })
            ->inRandomOrder()
            ->paginate(24);

        $sizes = Size::query()->where('is_active', 1)->get();
        $colors = Color::query()
            ->where('is_active', 1)
            ->where('display_in_search', 1)
            ->get();
        $prices = collect(['min' => 0, 'max' => 5000, 'values' => [75, 1000]]);

        return view('frontend.pages.shop', compact('products', 'title', 'categories', 'sizes', 'colors', 'prices', 'brands', 'sellers', 'populars'));
    }

    public function newArrivals()
    {
        $title = 'New Arrivals';

        $products = Product::query()
            ->active()
            ->orderByDesc('created_at')
            ->paginate(24);

        $categories = $this->categories();

        $brands = Brand::query()
            ->where('is_active', 1)
            ->orderBy('order')
            ->has('products')
            ->take(7)
            ->get();

        $sellers = Seller::query()
            ->where('is_active', 1)
            ->where('is_suspended', 0)
            ->has('products')
            ->get();

        $populars = Product::query()->inRandomOrder()->take(4)->get();

        $sizes = Size::query()->where('is_active', 1)->get();
        $colors = Color::query()
            ->where('is_active', 1)
            ->where('display_in_search', 1)
            ->get();
        $prices = collect(['min' => 0, 'max' => 5000, 'values' => [75, 1000]]);

        return view('frontend.pages.shop', compact('products', 'categories', 'sizes', 'colors', 'prices', 'brands', 'sellers', 'populars', 'title'));
    }

    public function trends()
    {
        $title = 'Trending';

        $products = Product::query()
            ->active()
            ->orderByDesc('total_viewed')
            ->paginate(24);

        $categories = $this->categories();

        $brands = Brand::query()
            ->where('is_active', 1)
            ->orderBy('order')
            ->has('products')
            ->take(7)
            ->get();

        $sellers = Seller::query()
            ->where('is_active', 1)
            ->where('is_suspended', 0)
            ->has('products')
            ->get();

        $populars = Product::query()->inRandomOrder()->take(4)->get();

        $sizes = Size::query()->where('is_active', 1)->get();
        $colors = Color::query()
            ->where('is_active', 1)
            ->where('display_in_search', 1)
            ->get();
        $prices = collect(['min' => 0, 'max' => 5000, 'values' => [75, 1000]]);

        return view('frontend.pages.shop', compact('products', 'categories', 'sizes', 'colors', 'prices', 'brands', 'sellers', 'populars', 'title'));
    }

    public function brands()
    {
        $brands = Brand::query()
            ->where('is_active', 1)
            ->orderBy('order')
            ->has('products')
            ->get();

        return view('frontend.pages.all-brands', compact('brands'));
    }

    public function aboutUs()
    {
        $page = (object)config('constants.about-us');
        return view('frontend.pages.blank', compact('page'));
    }

    public function customerService()
    {
        $page = (object)config('constants.customer-service');
        return view('frontend.pages.blank', compact('page'));
    }

    public function orderReturns()
    {
        $page = (object)config('constants.order-returns');
        return view('frontend.pages.blank', compact('page'));
    }

    public function privacyPolicy()
    {
        $page = (object)config('constants.privacy-policy');
        return view('frontend.pages.blank', compact('page'));
    }

    public function shippingPolicy()
    {
        $page = (object)config('constants.shipping-policy');
        return view('frontend.pages.blank', compact('page'));
    }

    public function sitemap()
    {
        $page = (object)config('constants.sitemap');
        return view('frontend.pages.blank', compact('page'));
    }

    public function support()
    {
        $page = (object)config('constants.support');
        return view('frontend.pages.blank', compact('page'));
    }

    public function helpline()
    {
        $page = (object)config('constants.helpline');
        return view('frontend.pages.blank', compact('page'));
    }

    public function affiliates()
    {
        $page = (object)config('constants.affiliates');
        return view('frontend.pages.blank', compact('page'));
    }

    public function liveSupport()
    {
        $page = (object)config('constants.live-support');
        return view('frontend.pages.blank', compact('page'));
    }

    public function customerCare()
    {
        $page = (object)config('constants.customer-care');
        return view('frontend.pages.blank', compact('page'));
    }

    /**
     * Resend email verification mail
     *
     * @return RedirectResponse
     */
    public function resend(): RedirectResponse
    {
        auth('customer')->user()->sendEmailVerificationNotification();
        return redirect()->back();
    }

    public function changeCurrency(Request $request)
    {
        $currency = Currency::query()->findOrFail($request->get('id'));

        $data = [
            'id' => $request->get('id'),
            'symbol' => $currency->symbol,
            'name' => $currency->name,
            'cc' => $currency->cc,
            'exchange_rate' => $currency->exchange_rate,
        ];

        Cookie::queue(Cookie::make('currency', json_encode($data)));

        return response($data);
    }

    public function changeLanguage(Request $request)
    {
        $language = Language::query()->findOrFail($request->get('id'));

        $data = [
            'id' => $request->get('id'),
            'name' => $language->name,
            'alias' => $language->alias,
            'direction' => $language->direction,
        ];

        Cookie::queue(Cookie::make('language', json_encode($data)));
        session()->put('locale', $language->alias);

        return response($data);
    }

    public function ajaxFilter(Request $request)
    {
        $p = Product::query()->orderByRaw('quantity = 0, quantity');

        // An explicitly selected category always wins over the slug of the page
        // the user happens to be on, otherwise switching categories would keep
        // showing the previous category's products.
        $categoryId = $request->get('category');
        $categoryId = is_numeric($categoryId) ? (int) $categoryId : null;

        $slug = $request->get('slug');
        $slug = (is_string($slug) && $slug !== '' && $slug !== 'undefined') ? $slug : null;

        if ($categoryId || $slug) {
            $category = Category::query()
                ->when($categoryId, function ($q) use ($categoryId) {
                    $q->where('id', $categoryId);
                }, function ($q) use ($slug) {
                    $q->where('slug', $slug);
                })
                ->first();

            if ($category) {
                $cats = [$category->id];

                foreach ($category->subCategories as $subCategory) {
                    $cats[] = $subCategory->id;
                    foreach ($subCategory->subCategories as $subSubCategory) {
                        $cats[] = $subSubCategory->id;
                    }
                }

                $p->whereIn('category_id', $cats);
            }
        }

        if ($request->has('color')) {
            $colors = $request->get('color');
            $p->whereHas('colors', function ($q) use ($colors) {
                $q->whereIn('color_id', $colors);
            });
        }

        if ($request->has('size')) {
            $sizes = $request->get('size');
            $p->whereHas('sizes', function ($q) use ($sizes) {
                $q->whereIn('size_id', $sizes);
            });
        }

        if ($request->has('brand')) {
            $brand = $request->get('brand');
            $p->whereIn('brand_id', $brand);
        }

        if ($request->has('seller')) {
            $seller = $request->get('seller');
            $p->whereIn('seller_id', $seller);
        }

        if ($request->has('min') && $request->has('max')) {
            $min = $request->get('min');
            $max = $request->get('max');
            if ($min >= 0 && $max > 0) {
                $p->whereBetween('sale_price', [$min, $max]);
            }
        }

        if ($request->has('sorting')) {
            $sortBy = $request->get('sorting');
            if ($sortBy == "price") {
                $p->orderBy('sale_price');
            } elseif ($sortBy == "popularity") {
                $p->orderByDesc('total_viewed');
            } else {
                $p->orderBy('id');
            }
        }

        // No manual skip() here: paginate() already resolves the current page
        // from the request. Combining both applied the offset twice (and with a
        // different page size), which broke pagination.
        $products = $p->where('is_active', 1)->paginate(24);

        return view('frontend.pages._ajax-product', compact('products'));
    }

    public function suggest(Request $request)
    {
        $products = Product::query()
            ->where('name', 'like', '%' . $request->get('query') . '%')
            ->inRandomOrder()
            ->take(4)
            ->get();

        $pro = [];

        foreach ($products as $product) {
            $pro[] = [
                'name' => $product->name,
                'image' => asset('uploads/products/galleries') . '/' . $product->images->first()->image,
                'link' => route('product', $product->slug)
            ];
        }

        $data['suggests'] = ['_' => $pro];

        return response(json_encode($data));
    }
    public function suggestNew(Request $request)
    {
        $search = trim((string) $request->get('search'));

        // Nothing useful to suggest for 0-1 characters, and returning every
        // product (as this used to) produced a ~780KB response on each keystroke.
        if (mb_strlen($search) < 2) {
            return response()->json([]);
        }

        $products = Product::query()
            ->with('images', 'promotionsActive')
            ->where('is_active', 1)
            ->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('tags', 'like', '%' . $search . '%')
                    ->orWhere('sku', 'like', '%' . $search . '%');
            })
            ->orderByRaw('quantity = 0, quantity')
            ->take(6)
            ->get();

        return response()->json($products);
    }

    /**
     * Store email subscriber to database
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function subscribe(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'email' => 'required|email|unique:email_subscribers',
        ]);

        $email = $request->get('email');

        EmailSubscriber::query()->create(['email' => $email]);

        Session::flash('success', 'You are listed in our daily newsletter');

        return redirect()->back();
    }

    /**
     * A collection of active categories
     *
     * @return Collection
     */
    public function categories(): Collection
    {
        return Category::query()
            ->where('is_active', 1)
            ->orderBy('order')
            ->where('category_id', null)
            ->take(16)
            ->get();
    }

    public function sendToSeller(Request $request)
    {
        $request['sender'] = 'customer';
        $m = Message::query()->create($request->all());
        return response([$m]);
    }
}
