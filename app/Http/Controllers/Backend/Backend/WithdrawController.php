<?php

namespace App\Http\Controllers\Backend;

use App\Models\Withdraw;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Backend\SellerManagement\Entities\Seller;

class WithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total_withdraws = Withdraw::sum('amount');
        $pending_withdraws = Withdraw::where('status', 'pending')->sum('amount');
        $approved_withdraws = Withdraw::where('status', 'approved')->sum('amount');
        $rejected_withdraws = Withdraw::where('status', 'rejected')->sum('amount');
        return view('backend.pages.withdraws.index', compact('total_withdraws', 'pending_withdraws', 'approved_withdraws', 'rejected_withdraws'));
    }

    public function withdrawDatas(Request $request)
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

        $query = Withdraw::query();
        // Total records
        $totalRecords = $query->count();
        $totalRecordswithFilter = $totalRecords;
        // Get records, also we have included search filter as well
        if (!empty($searchValue)) {
            $query
                ->where('trx_id', 'like', '%' . $searchValue . '%')
                ->orWhere('status', 'like', '%' . $searchValue . '%')
                ->orWhere('bank_name', 'like', '%' . $searchValue . '%')
                ->orWhere('bank_branch', 'like', '%' . $searchValue . '%')
                ->orWhere('account_holder', 'like', '%' . $searchValue . '%')
                ->orWhere('account', 'like', '%' . $searchValue . '%')
                ->orWhere('account_type', 'like', '%' . $searchValue . '%')
                ->orWhere('routing_number', 'like', '%' . $searchValue . '%')
                ->orWhere('swift_code', 'like', '%' . $searchValue . '%')
                ->orWhere('amount', 'like', '%' . $searchValue . '%')
                ->orWhere('note', 'like', '%' . $searchValue . '%')
                ->orWhere('created_at', 'like', '%' . $searchValue . '%');
            $totalRecordswithFilter = $query->count();
        }
        $records = $query
            ->orderBy($columnName, $columnSortOrder)
            ->with('seller')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            $class = 'warning';
            if ($record->status == 'approved') {
                $class = 'success';
            } elseif ($record->status == 'rejected') {
                $class = 'danger';
            }
            $data_arr[] = array(
                "trx_id" =>  $record->cancel_note,
                "account_holder" =>  $record->account_holder,
                "seller" =>  $record->seller->first_name ?? '',
                "account" =>  $record->account,
                "amount" =>  currency($record->amount,2),
                "withdraw_date" => date("d M Y", strtotime($record->created_at)) . ' at ' . date("h:i A", strtotime($record->created_at)),
                "status" => '<div class="badge bg-'.$class.'">'.$record->status.'</div>',
                "action" => '<div class="btn-group"><a class="btn btn-warning btn-sm" href="'.route('backend.withdraws.show', $record->id).'">' . '<i class="fa-solid fa-eye"></i></a>' . '<a class="btn btn-danger btn-sm action-confirm" data-action="'.route('backend.withdraws.destroy', $record->id).'">' . '<i class="fa-solid fa-trash"></i></a></div>',
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $withdraw = Withdraw::with('seller')->findOrFail($id);
        return view('backend.pages.withdraws.show', compact('withdraw'));
    }

    public function approved(Request $request)
    {
        $withdraw = Withdraw::find($request->withdraw);
        if ($withdraw->status == 'rejected') {
            $user = Seller::find($withdraw->seller_id);
            $user->update([
                'wallet' => $user->wallet - $withdraw->amount
            ]);
        }

        $withdraw->update([
            'status' => 'approved'
        ]);

        return response()->json([
            'message' => __('Withdraw approved successfully.'),
            'redirect' => route('backend.withdraws.index')
        ]);
    }

    public function reject(Request $request)
    {
        $withdraw = Withdraw::find($request->withdraw);
        $user = Seller::find($withdraw->seller_id);
        $user->update([
            'wallet' => $user->wallet + $withdraw->amount
        ]);
        $withdraw->update([
            'status' => 'rejected'
        ]);

        return response()->json([
            'message' => __('Withdraw rejected successfully.'),
            'redirect' => route('backend.withdraws.index')
        ]);
    }

    public function destroy($id)
    {
        $withdraw = Withdraw::findOrFail($id);
        $withdraw->delete();

        return response()->json([
            'redirect' => route('backend.withdraws.index'),
            'message' => __('Withdraw deleted successfully.')
        ]); 
    }
}
