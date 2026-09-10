<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseMessage;
use App\Modules\Backend\OrderManagement\Entities\Order;
use App\Modules\Backend\OrderManagement\Entities\OrderDetail;

class WalletController extends Controller
{
    use ResponseMessage;
    /* stock report */
    public function earning()
    {
        $query = OrderDetail::query();

        $query
            ->where('order_details.seller_id', 'like', '%' . auth()->id() . '%');
        $query
            ->join('orders', 'orders.id', 'order_details.order_id')
            ->leftJoin('seller_commissions', 'seller_commissions.seller_id', 'order_details.seller_id')
            ->join('products', 'products.id', 'order_details.product_id')
            ->select('orders.order_no as order_no', 'seller_commissions.seller_commission as commission', 'products.sku as sku', 'order_details.*');

        $records = $query
            ->with('orderStatus')
            ->get();

        $data_arr = array();

        foreach ($records as $record) {

            $data_arr[] = array(
                "total_price" => $record->total_price ?? '',
                "commission" => number_format($record->commission, 2) . '%' ?? '',
                "commission_amount" => (($record->commission * $record->total_price) / 100) ?? '',
                "payout_amount" => ($record->total_price - (($record->commission * $record->total_price) / 100))

            );
        }
        $data['withdraw_amount']        =  SellerWithdraw::where('seller_id', auth('seller')->id())->where('withdraw_status', 'Proceed')->sum('amount');
        $data['payout_amount']          =  number_format(array_sum(array_column($data_arr, 'payout_amount')), 2);
        $data['unpaid_payout_amount']   =  number_format(array_sum(array_column($data_arr, 'payout_amount')) - $data['withdraw_amount'], 2);


        return view('backend.pages.wallet.earning', compact('data'));
    }

    /* Process ajax request */
    public function earningList(Request $request)
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

        $query = OrderDetail::query();

        $query
            ->where('order_details.seller_id', 'like', '%' . auth()->id() . '%');
        $query
            ->join('orders', 'orders.id', 'order_details.order_id')
            ->leftJoin('seller_commissions', 'seller_commissions.seller_id', 'order_details.seller_id')
            ->join('products', 'products.id', 'order_details.product_id')
            ->select('orders.order_no as order_no', 'seller_commissions.seller_commission as commission', 'products.sku as sku', 'order_details.*');
        // Total records
        $totalRecords = $query->count();
        $totalRecordswithFilter = $totalRecords;
        // Get records, also we have included search filter as well
        if (!empty($searchValue)) {
            $query
                ->where('order_no', 'like', '%' . $searchValue . '%')
                ->orWhere('sku', 'like', '%' . $searchValue . '%')
                ->orWhere('total_price', 'like', '%' . $searchValue . '%')
                ->orWhere('commission', 'like', '%' . $searchValue . '%')
                ->orWhere('order_status', 'like', '%' . $searchValue . '%')
                ->orWhere('created_at', 'like', '%' . $searchValue . '%');
            $totalRecordswithFilter = $query->count();
        }
        $records = $query
            ->with('orderStatus')
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {

            $show_route = route('seller.orders.show', $record->id);

            $data_arr[] = array(
                "order_no" => '<a title="' . $record->cancel_note . '" href="' . $show_route . '"><span>' . $record->order_no . '</span>' . '</a>',

                "order_date" => date("d M Y", strtotime($record->created_at)) . ' at ' . date("h:i A", strtotime($record->created_at)),
                "sku" => $record->sku ?? '',
                "total_price" => number_format($record->total_price, 2) ?? '',
                "commission" => number_format($record->commission, 2) . '%' ?? '',
                "payout_amount" => number_format(($record->total_price - (($record->commission * $record->total_price) / 100)), 2),
                "order_status" => $record->orderStatus->name ?? '',
                "payout_status" => $record->orderStatus->name ?? '',
            );
        }
        //$sum =$data_arr->sum('payout_amount');

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );

        return json_encode($response);
    }
}
