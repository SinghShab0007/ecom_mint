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
    public function orderStatusChange(Request $request)
    {
        $request->validate([
            'status' => 'required|integer',
            'order_id' => 'required|integer',
        ]);

        if ($request->status == 7 || $request->status == 8)
        {
            $status = $request->status;
            $order = OrderDetail::query()->findOrFail($request->order_id);

            if ($order->color) {
                $color = Color::where('name', $order->color)->first()->id;
                Session::put('color_id', $color);
            }

            if ($order->size) {
                $size = Size::where('name', $order->size)->first()->id;
                Session::put('size_id', $size);
            }

            // Notification to seller
            $message = $request->status == 7 ? __('Order has been cancled.') : __('Order has been returned.');
            $this->SellerNotification($order->seller_id, $order->order_id, route('seller.orders.index', ['order' => $order->order_id]), $message);

            if(Gate::denies('access',$order)){
                abort(401);
            }
            $cancellationPolicy = Page::query()->where('menu_id',17)->first();
            return view('customer.pages.order-cancel', compact('order','cancellationPolicy', 'status'));
        } else {
            return back()->with('error', __('Unknown status.'));
        }
    }

    /**
     * Display an order list in customer dashboard
     *
     * @param Request $request
     * @return View
     */
    public function list(Request $request): View
    {
        $order = OrderDetail::query()->where('user_id',auth('customer')->id());

        if($request->has('stat')){
            $stat = $request->get('stat');
            if($stat > 0){
                $order->where('order_stat',$stat);
            }
        }else{
            $stat = 0;
        }

        if($request->has('search')){
            $search = $request->get('search');
            $order->where('order_no','like','%'.$search.'%');
        }

        $orders = $order->latest()->paginate(10);

        return view('customer.pages._order_list',compact('orders','stat'));
    }

    public function cancel(Request $request, $id)
    {
        $is_confirm = $request->get('confirm');

        if(!$is_confirm){
            return redirect()->back();
        }

        $details = OrderDetail::query()->findOrFail($id);
        $order = Order::query()->findOrFail($details->order_id);

        $product = Product::find($details->product_id);
        if ($product->is_manage_stock) {
            $product->quantity = $product->quantity + $details->qty;
            $product->save();
        }

        if ($details->color || $details->size) {
            $stock = Productstock::where('product_id', $product->id)->where('color_id', session('color_id'))->where('size_id', session('size_id'))->first();
            $stock->quantities = $stock->quantities + $details->qty;
            $stock->save();
        }

        if(Gate::denies('access',$order)){
            abort(401);
        }

        if ($order->payment_status === 'paid')
        {
            $product = Product::findOrFail($request->product_id);
            $cateogry = Category::findOrFail($product->category_id);
            $seller = Seller::findOrFail($product->seller_id);

            $commission = ($details->sale_price / 100) * $cateogry->commission_rate;
            $seller->update([
                'wallet' => $seller->wallet - ($details->sale_price - $commission)
            ]);
        }

        $data = [
            'order_detail_id' => $id,
            'user_id' => auth('customer')->id(),
            'product_id' => $request->product_id,
            'order_stat' => $request->order_stat,
            'order_stat_desc' => $request->order_stat_desc,
            'order_stat_datetime' => now(),
            'remarks' => $request->remarks,
        ];

        OrderTimeline::query()->create($data);

        $details->update(['order_stat' => $request->order_stat]);

        return redirect('order');
    }
}
