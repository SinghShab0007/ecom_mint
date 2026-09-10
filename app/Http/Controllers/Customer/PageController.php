<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Backend\Country;
use App\Models\Frontend\FAQ;
use App\Models\Frontend\PaymentGateway;
use App\Models\Frontend\ShippingAddress;
use App\Models\Frontend\UserBilling;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cookie;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    /**
     * Display checkout page
     *
     * @return View
     */
    public function checkout()
    {
        $cart = Cookie::get('cart');
        $carts = json_decode($cart);

        if (!$carts) return back()->with('error', __('Your cart is empty!'));

        $billing = UserBilling::query()
            ->where('user_id', auth('customer')->id())
            ->where('is_active', 1)
            ->first();

        $shipping = ShippingAddress::query()
            ->where('user_id', auth('customer')->id())
            ->latest()
            ->first();

        $gatewayEnabled = PaymentGateway::query()
            ->where('name', PaymentController::GATEWAY)
            ->where('status', 1)
            ->exists();

        return view('customer.checkout.checkout', compact('carts', 'billing', 'shipping', 'gatewayEnabled'));
    }

    /**
     * Display Announcement Page
     *
     * @return View
     */
    public function announcement(): View
    {
        return view('customer.pages.announcement');
    }

    /**
     * Display FAQ Page
     *
     * @return View
     */
    public function faq(): View
    {
        $faqs = FAQ::query()->where('is_active',1)->paginate(10);
        return view('customer.pages.faq',compact('faqs'));
    }
}
