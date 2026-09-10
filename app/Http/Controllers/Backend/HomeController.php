<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseMessage;
use App\Models\Backend\WebAppearance;
use App\Modules\Backend\CustomerManagement\Entities\Customer;
use App\Modules\Backend\OrderManagement\Entities\Order;
use App\Modules\Backend\OrderManagement\Entities\OrderDetail;
use App\Modules\Backend\OrderManagement\Http\Controllers\OrderController;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Symfony\Component\HttpFoundation\Request;


class HomeController extends Controller
{
    use ResponseMessage;

    protected $order = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->order = new OrderController();
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        $order_overview = $this->order->orderOverview();

        $website_appearance = WebAppearance::query()->find(1);

        $total_sale = Order::query()->whereHas('details', function ($q) {
            $q->where('seller_id', 'like', '%' . auth()->id() . '%');
        })->whereYear('created_at', Carbon::today('Y'))->sum('total_price');

        $new_customers = Customer::with('orders')
            ->withCount('orders')
            ->whereHas('orders.details',function ($q) {
                $q->where('seller_id', auth()->id());
            })
            ->orderBy('orders_count', 'desc')->take(3)->get();

        $new_orders = OrderDetail::query()
            ->where('seller_id', 'like', '%' . auth()->id() . '%')
            ->orderBy('id', 'desc')
            ->take(7)
            ->get();

        $monthly_sale_products = $this->monthly_sale(date('Y-m'));
        $previous_month_sale_products = $this->monthly_sale(date("Y-m", strtotime('-1 month')));

        $best_selling_category = $this->bestCategory(date('Y-m'));


        return view('backend.pages.home', compact('order_overview', 'website_appearance', 'total_sale', 'new_orders', 'new_customers', 'monthly_sale_products', 'previous_month_sale_products', 'best_selling_category'));
    }

    public function monthlySale(Request $request)
    {
        $month = $request->input('month');
        $monthly_sale_products = $this->monthly_sale($month);
        $previous_month_sale_products = $this->monthly_sale(date("Y-m", strtotime('-1 month', strtotime($month))));

        return response()->json([
            'data' => compact('monthly_sale_products', 'previous_month_sale_products'),
            'success' => 'true',
            'message' => 'Successfully Load Data',
        ]);
    }

    private function monthly_sale($month)
    {
        $start = $month . '-01 00:00:00';
        $end = $month . '-31 23:59:59';

        $query = OrderDetail::query();

        // specific seller
        if (auth('seller')->user() && auth('seller')->user()->getRoleNames()->first() == 'Seller') {
            $query->where('seller_id', 'like', '%' . auth()->id() . '%');
        }

        $monthly_sales = $query->select('id', 'created_at', 'qty')
            ->whereBetween('created_at', [$start, $end])
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('d'); // grouping by months
            });

        $product_count = [];
        $monthly_sale_products = [];
        foreach ($monthly_sales as $key => $value) {
            $sum = 0;
            foreach ($value as $product) {
                $sum += $product->qty;
            }
            $product_count[(int)$key] = $sum;
        }
        $days = date("t");
        for ($i = 1; $i <= $days; $i++) {
            if (!empty($product_count[$i])) {
                $monthly_sale_products[$i] = $product_count[$i];
            } else {
                $monthly_sale_products[$i] = 0;
            }
        }
        return ($monthly_sale_products);
    }

    public function bestSellingProducts(Request $request)
    {
        $month = $request->input('month');
        $start = $month . '-01 00:00:00';
        $end = $month . '-31 23:59:59';
        $query = OrderDetail::query();
        $website_appearance = WebAppearance::find(1);

        // specific seller
        if (auth('seller')->user() && auth('seller')->user()->getRoleNames()->first() == 'Seller') {
            $query->where('seller_id', 'like', '%' . auth()->id() . '%');
        }
        $best_selling_products = $query
            ->with('product', 'product.images')
            ->whereBetween('created_at', [$start, $end])
            ->selectRaw('product_id, count(*) as total')
            ->groupBy('product_id')
            ->orderByDesc('total')
            ->take('7')
            ->get();
        return response()->json([
            'product' => view('backend.pages._best_selling_product', compact('best_selling_products', 'website_appearance'))->render(),
            'success' => 'true',
            'message' => 'Successfully Load Data',
        ]);
    }

    public function bestSellingProductCategory(Request $request)
    {
        $month = $request->input('month');
        $best_selling_category = $this->bestCategory($month);
        if (!empty($best_selling_category['category_count'])) {
            $view = view('backend.pages._monthly_category_status', compact('best_selling_category'))->render();
        } else {
            $view = '';
        }
        return response()->json([
            'view' => $view,
            'best_selling_category' => $best_selling_category,
            'success' => 'true',
            'message' => 'Successfully Load Data',
        ]);
    }

    private function bestCategory($month)
    {
        $start = $month . '-01 00:00:00';
        $end = $month . '-31 23:59:59';

        $query = OrderDetail::query();

        // specific seller
        if (auth('seller')->user() && auth('seller')->user()->getRoleNames()->first() == 'Seller') {
            $query->where('seller_id', 'like', '%' . auth()->id() . '%');
        }
        $best_category = $query
            ->with('product.category')
            ->whereBetween('created_at', [$start, $end])
            ->selectRaw('product_id, count(*) as total')
            ->groupBy('product_id')
            ->orderByDesc('total')
            ->take('4')
            ->get();
        $category_count = [];
        $category_name = [];
        foreach ($best_category as $key => $detail) {
            $category_count[] = $detail->total;
            $category_name[] = $detail->product->category->name ?? '';
        }

        return compact('category_count', 'category_name');
    }

    public function bestCustomers(Request $request)
    {
        $month = $request->input('month');
        $start = $month . '-01 00:00:00';
        $end = $month . '-31 23:59:59';
        $query = Customer::query();

        $best_customers = $query->whereHas('orders', function ($query) use ($start, $end) {
            $query->whereBetween('created_at', [$start, $end]);
        })
            ->with('orders')->withCount('orders')
            ->orderByDesc('orders_count')
            ->take('7')
            ->get();
        return response()->json([
            'customers' => view('backend.pages._best_customers', compact('best_customers'))->render(),
            'success' => 'true',
            'message' => 'Successfully Load Data',
        ]);
    }

    public function newOrders(Request $request)
    {
        $status = $request->input('status');
        $query = OrderDetail::query();
        // specific seller
        if (auth('seller')->user() && auth('seller')->user()->getRoleNames()->first() == 'Seller') {
            $query->where('seller_id', 'like', '%' . auth('seller')->id() . '%');
        }
        $new_orders = $query
            ->with('orderStatus', 'product', 'order')->orderBy('id', 'desc')
            ->where('order_stat', $status)
            ->take(7)
            ->get();

        return response()->json([
            'orders' => view('backend.pages._new_orders', compact('new_orders'))->render(),
            'success' => 'true',
            'message' => count($new_orders)>0?'Successfully Load Data':'No Data Found',
        ]);

    }
}
