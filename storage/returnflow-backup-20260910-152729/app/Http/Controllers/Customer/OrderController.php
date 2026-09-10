<?php

namespace App\Http\Controllers\Customer;

use App\Models\Productstock;
use Illuminate\Http\Request;
use App\Helpers\NotifyHelper;
use App\Models\Frontend\Page;
use App\Models\Frontend\Size;
use App\Models\Frontend\Color;
use App\Models\Frontend\Order;
use App\Models\Seller\Product;
use App\Models\Frontend\Seller;
use App\Models\Seller\Category;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Models\Frontend\OrderDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Models\Frontend\OrderTimeline;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    use NotifyHelper;

    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    /**
     * Display order list
     *
     * @return View
     */
    public function index(): View
    {
        $orders = OrderDetail::query()
            ->where('user_id',auth()->id())
            ->paginate(10);

        $stat = 0;

        return view('customer.pages.order',compact('orders','stat'));
    }

    public function invoice($id)
    {
        $order = Order::query()->findOrFail($id);

        if(Gate::denies('access',$order)){
            abort(401);
        }

        $customer = $order->customer;

        return view('customer.pages.invoice',compact('order','customer'));
    }

    /**
     * Display an ordered item details
     *
     * @param $id
     * @return View
     */
    public function details($id): View
    {
        $order = OrderDetail::query()->with('seller:id,company_name')->findOrFail($id);
        if(Gate::denies('access',$order)){
            abort(401);
        }

        return view('customer.pages.order-details',compact('order'));
    }

    /**
     * Display the order cancel page
     *
     * @param $id
     * @return View
     */
    /** Cancel (7) and Return (8) both land here to confirm before committing. */
    public function orderStatusChange(Request $request)
    {
        $request->validate([
            'status' => 'required|integer|in:7,8',
            'order_id' => 'required|integer',
        ]);

        $status = (int) $request->status;
        $order = OrderDetail::query()->findOrFail($request->order_id);

        // Authorise before doing anything else.
        if (Gate::denies('access', $order)) {
            abort(401);
        }

        if (in_array((int) $order->order_stat, [7, 8], true)) {
            return redirect()->route('customer.order')
                ->with('error', __('This item has already been cancelled or returned.'));
        }

        // A colour/size recorded on the order may no longer exist in the lookup
        // tables. optional() keeps a missing row from fataling the whole page.
        if ($order->color) {
            Session::put('color_id', optional(Color::where('name', $order->color)->first())->id);
        }
        if ($order->size) {
            Session::put('size_id', optional(Size::where('name', $order->size)->first())->id);
        }

        $message = $status === 7 ? __('Order has been cancelled.') : __('Order has been returned.');
        if ($order->seller_id) {
            $this->SellerNotification($order->seller_id, $order->order_id, route('seller.orders.index', ['order' => $order->order_id]), $message);
        }

        $cancellationPolicy = Page::query()->where('menu_id', 17)->first();

        return view('customer.pages.order-cancel', compact('order', 'cancellationPolicy', 'status'));
    }

    /**
     * Commit a cancellation (7) or return (8) for one order line.
     */
    public function cancel(Request $request, $id)
    {
        $request->validate([
            'order_stat' => 'required|integer|in:7,8',
            'order_stat_desc' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:1000',
        ]);

        if (!$request->get('confirm')) {
            return redirect()->back()->with('error', __('Please accept the policy to continue.'));
        }

        $details = OrderDetail::query()->findOrFail($id);
        $order = Order::query()->findOrFail($details->order_id);

        // Authorise FIRST. This used to run after stock had already been
        // restored, so a request for someone else's order still inflated
        // inventory before returning 401.
        if (Gate::denies('access', $order)) {
            abort(401);
        }

        if (in_array((int) $details->order_stat, [7, 8], true)) {
            return redirect()->route('customer.order')
                ->with('error', __('This item has already been cancelled or returned.'));
        }

        $newStat = (int) $request->order_stat;

        DB::transaction(function () use ($details, $order, $request, $newStat) {
            // Always the product recorded on the order line - never
            // $request->product_id, which the buyer controls and could point at
            // another seller's product.
            $product = Product::find($details->product_id);

            if ($product && $product->is_manage_stock) {
                $product->quantity += $details->qty;
                $product->save();
            }

            if ($product && ($details->color || $details->size)) {
                $stock = Productstock::where('product_id', $product->id)
                    ->where('color_id', Session::get('color_id'))
                    ->where('size_id', Session::get('size_id'))
                    ->first();

                // A variant row may have been removed since the order was placed.
                if ($stock) {
                    $stock->quantities += $details->qty;
                    $stock->save();
                }
            }

            // Claw the commission back only for money actually collected.
            if ($order->payment_status === 'paid' && $product) {
                $category = $product->category_id ? Category::find($product->category_id) : null;
                $seller = $product->seller_id ? Seller::find($product->seller_id) : null;

                if ($seller && $category) {
                    $commission = ($details->sale_price / 100) * $category->commission_rate;
                    $seller->update(['wallet' => $seller->wallet - ($details->sale_price - $commission)]);
                }
            }

            OrderTimeline::query()->create([
                'order_detail_id' => $details->id,
                'user_id' => auth('customer')->id(),
                'product_id' => $details->product_id,
                'order_stat' => $newStat,
                'order_stat_desc' => $request->order_stat_desc,
                'order_stat_datetime' => now(),
                'remarks' => $request->remarks,
            ]);

            $details->update(['order_stat' => $newStat]);
        });

        Session::forget(['color_id', 'size_id']);

        return redirect()->route('customer.order')->with('status', $newStat === 8
            ? __('Your return request has been submitted.')
            : __('Your cancellation request has been submitted.'));
    }
}
