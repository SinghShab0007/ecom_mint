<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Backend\WebAppearance;
use App\Models\Frontend\OrderDetail;
use App\Models\Seller\Customer;
use App\Models\Seller\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:seller');
    }

    public function index()
    {

        $order_overview = $this->orderOverview();

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

        return view('seller.pages.home', compact('order_overview', 'website_appearance', 'total_sale', 'new_orders', 'new_customers', 'monthly_sale_products', 'previous_month_sale_products', 'best_selling_category'));
    }

    public function orderOverview()
    {
        $query = OrderDetail::query();

        // specific seller
        if (auth('seller')->user()) {
            $query->where('seller_id', 'like', '%' . auth()->id() . '%');
        }
        $orders = $query
            ->selectRaw('order_stat, count(*) as total')
            ->groupBy('order_stat')
            ->get();
        $order_overview = [];
        foreach ($orders as $key => $order) {
            $order_overview[$order->order_stat] = $order->total;
        }
        $order_overview['total_order'] = array_sum($order_overview);
        return $order_overview;
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

}
