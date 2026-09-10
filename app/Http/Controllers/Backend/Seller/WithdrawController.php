<?php

namespace App\Http\Controllers\Seller;

use App\Models\Withdraw;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class WithdrawController extends Controller
{
    public function index()
    {
        $total_withdraws = Withdraw::where('seller_id', auth('seller')->id())->sum('amount');
        $pending_withdraws = Withdraw::where('seller_id', auth('seller')->id())->where('status', 'pending')->sum('amount');
        $approved_withdraws = Withdraw::where('seller_id', auth('seller')->id())->where('status', 'approved')->sum('amount');
        $rejected_withdraws = Withdraw::where('seller_id', auth('seller')->id())->where('status', 'rejected')->sum('amount');
        return view('seller.withdraws.index', compact('total_withdraws', 'pending_withdraws', 'approved_withdraws', 'rejected_withdraws'));
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
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            $data_arr[] = array(
                "trx_id" =>  $record->cancel_note,
                "account_holder" =>  $record->account_holder,
                "account" =>  $record->account,
                "amount" =>  number_format($record->amount, 2),
                "withdraw_date" => date("d M Y", strtotime($record->created_at)) . ' at ' . date("h:i A", strtotime($record->created_at)),
                "status" => $record->status,
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

    public function create()
    {
        return view('seller.withdraws.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string',
            'bank_branch' => 'required',
            'account_holder' => 'required',
            'account' => 'required',
            'account_type' => 'nullable|string',
            'note' => 'required',
            'password' => 'required',
            'amount' => 'required|integer|min:1',
        ]);

        if (Hash::check($request->password, auth()->user()->password)) {
            if (auth()->user()->wallet >= $request->amount) {

                Withdraw::create($request->all() + [
                    'seller_id' => auth('seller')->id()
                ]);

                auth()->user()->update([
                    'wallet' => auth()->user()->wallet - $request->amount
                ]);

                // if (env('QUEUE_MAIL')) {
                //     Mail::to(auth()->user()->email)->queue(new OtpMail($otp));
                // } else {
                //     Mail::to(auth()->user()->email)->send(new OtpMail($otp));
                // }

                return response()->json([
                    'redirect' => route('seller.withdraw_earning'),
                    'message' => "Withdraw request created successfully. Please wait for approval."
                ]);
            } else {
                return response()->json('Insufficient balance. Your balance is ' . (auth()->user()->wallet ?? 0), 404);
            }
        } else {
            return response()->json(__('Incorrect password.'), 404);
        }
    }
}
