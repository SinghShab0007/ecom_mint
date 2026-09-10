<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Modules\Backend\OrderManagement\Entities\Order;
use App\Modules\Backend\ProductManagement\Entities\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class ReportController extends Controller
{

    /* stock report */
    public function stockReport()
    {
        return view('backend.pages.reports.stock_report');
    }

    /* Process ajax request */
    public function stockReportList(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // total number of rows per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        $query = Product::query();
        // Total records
        $totalRecords = $query->count();
        $totalRecordswithFilter = $totalRecords;
        // Get records, also we have included search filter as well
        if (!empty($searchValue)) {
            $query
                ->where('name', 'like', '%' . $searchValue . '%')
                ->orWhere('id', 'like', '%' . $searchValue . '%')
                ->orWhere('sku', 'like', '%' . $searchValue . '%')
                ->orWhere('unit_price', 'like', '%' . $searchValue . '%')
                ->orWhere('quantity', 'like', '%' . $searchValue . '%')
                ->orWhere('total_viewed', 'like', '%' . $searchValue . '%');
            $totalRecordswithFilter = $query->count();
        }
        $records = $query
            ->with('images')
            ->withSum('orders', 'qty')
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            $image = '';
            foreach ($record->images as $k => $img) {
                $image = '<img src="' . URL::to('uploads/products/galleries/' . $img->image) . '" width="60px"
                                             height="60px" alt="product">';
                break;
            }

            $data_arr[] = array(
                "name" => $record->name,
                "image" => $image,
                "sku" => $record->sku,
                "unit_price" => $record->unit_price,
                "quantity" => $record->quantity,
                "orders_sum_qty" => $record->order_sum_qty,
                "total_viewed" => $record->total_viewed,
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );

        return json_encode($response);
    }

    /* show seller report */
    public function sellerReport()
    {
        $orders = Order::with('details', 'details.seller')->whereHas('details')->paginate(20);
        return view('backend.pages.reports.seller_report', compact('orders'));
    }

    /* Process ajax request */
    public function sellerReportList(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // total number of rows per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        $query = Order::query();
        $query
            ->join('order_details', 'order_details.order_id', '=', 'orders.id')
            ->join('sellers', 'sellers.id', '=', 'order_details.seller_id')
            ->select('sellers.company_name as company_name','sellers.last_name as last_name', 'sellers.first_name as first_name', 'sellers.mobile as mobile', 'sellers.email as email', 'orders.*');
        // Total records
        $totalRecords = $query->count();
        $totalRecordswithFilter = $totalRecords;
        // Get records, also we have included search filter as well
        if (!empty($searchValue)) {
            $query
                ->where('orders.order_no', 'like', '%' . $searchValue . '%')
                ->orWhere('company_name', 'like', '%' . $searchValue . '%')
                ->orWhere('mobile', 'like', '%' . $searchValue . '%')
                ->orWhere('email', 'like', '%' . $searchValue . '%')
                ->orWhere('orders.id', 'like', '%' . $searchValue . '%');

            $totalRecordswithFilter = $query->count();
        }
        $records = $query
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();
        foreach ($records as $record) {
            $data_arr[] = array(
                "order_no" => '<a href="' . route("backend.orders.show",$record->id) . '"><span>' . $record->order_no . '</span>' .
                    date("d M Y", strtotime($record->created_at)) .
                    ' at ' . date("g:m A", strtotime($record->created_at)) . '</a>',

                "company_name" => $record->company_name,
                "mobile" => $record->mobile,
                "email" => $record->email,
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );

        return json_encode($response);
    }

    /* show customer report */
    public function customerReport()
    {
        return view('backend.pages.reports.customer_report');
    }

    /* Process ajax request */
    public function customerReportList(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // total number of rows per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        $query = Order::query();
        // Total records
        $totalRecords = $query->count();
        $totalRecordswithFilter = $totalRecords;
        $query
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->select('users.last_name as last_name', 'users.first_name as first_name', 'users.mobile as mobile', 'users.email as email', 'orders.*');
        // Get records, also we have included search filter as well
        if (!empty($searchValue)) {
            $query
                ->where('order_no', 'like', '%' . $searchValue . '%')
                ->orWhere('first_name', 'like', '%' . $searchValue . '%')
                ->orWhere('last_name', 'like', '%' . $searchValue . '%')
                ->orWhere('mobile', 'like', '%' . $searchValue . '%')
                ->orWhere('email', 'like', '%' . $searchValue . '%')
                ->orWhere('shipping_address_1', 'like', '%' . $searchValue . '%')
                ->orWhere('total_price', 'like', '%' . $searchValue . '%')
                ->orWhere('orders.id', 'like', '%' . $searchValue . '%');

            $totalRecordswithFilter = $query->count();
        }
        $records = $query
            ->with('customer')
            ->withSum('details', 'qty')
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            $data_arr[] = array(
                "order_no" => '<a href="' . route("backend.orders.show",$record->id) . '"><span>' . $record->order_no . '</span>' .
                    date("d M Y", strtotime($record->created_at)) .
                    ' at ' . date("g:m A", strtotime($record->created_at)) . '</a>',

                "last_name" => $record->customer->full_name(),
                "mobile" => $record->customer->mobile,
                "email" => $record->customer->email,
                "shipping_address_1" => $record->shipping_address_1,
                "details_sum_qty" => $record->details_sum_qty,
                "total_price" => $record->total_price,
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );

        return json_encode($response);
    }
}
