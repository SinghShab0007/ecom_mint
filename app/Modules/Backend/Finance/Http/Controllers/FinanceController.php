<?php

namespace App\Modules\Backend\Finance\Http\Controllers;

use App\Models\Frontend\OrderDetail;
use App\Models\Seller\Order;
use App\Models\Seller\Sale;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function statement(Request $request)
    {
        $start = new Carbon('first day of '.$request->month.' '.$request->year);
        $end = new Carbon('last day of '.$request->month.' '.$request->year);

        $orders = Order::query()
            ->whereBetween('created_at',[$start,$end])
            ->get();

        return view('finance::statement',compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function orders()
    {
        $sales = Sale::query()
            //->where('seller_id',auth()->id())
            ->paginate(10);

        return view('finance::orders',compact('sales'));
    }

}
