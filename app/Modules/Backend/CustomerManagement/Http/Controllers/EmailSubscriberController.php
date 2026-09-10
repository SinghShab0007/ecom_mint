<?php

namespace App\Modules\Backend\CustomerManagement\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseMessage;
use App\Models\Frontend\EmailSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Mockery\CountValidator\Exception;
use App\Modules\Backend\CustomerManagement\Entities\Customer;

class EmailSubscriberController extends Controller
{
    use ResponseMessage;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('customermanagement::email_subscriber.index');
    }

    /* Process ajax request */
    public function emailSubscriberList(Request $request)
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

        $query = EmailSubscriber::query();

        // Total records
        $totalRecords = $query->count();
        $totalRecordswithFilter = $totalRecords;
        // Get records, also we have included search filter as well
        if (!empty($searchValue)) {
            $query
                ->where(function ($qry) use ($searchValue) {
                    $qry->orWhere('email', 'like', '%' . $searchValue . '%');
                });

            $totalRecordswithFilter = $query->count();
        }
        $records = $query
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            $checked = '';
            if ($record->opt_out)
                $checked = 'checked';

            $data_arr[] = array(
                "email" => $record->email,
                "opt_out" => '<div class="form-switch"><input class="form-check-input status" type="checkbox"  data-id="' . $record->id . '"' . $checked . '></div>',

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

    /* change status*/
    public function changeStatus(Request $request)
    {
        $email_subscriber = EmailSubscriber::findOrFail($request->id);
        if ($email_subscriber) {
            if ($request->field == 'opt_out')
                $email_subscriber->opt_out = $request->status;
            $email_subscriber->save();
            return response()->json($this->update_success_message);
        } else {
            return response()->json($this->not_found_message);
        }

    }


    /*send mail to customer */

    public function sendMail(Request $request)
    {
        $data = [];
        $data = (object)$request->all();
        $mail_template = 'backend.emails.customer';

        try {
            Mail::send($mail_template, ['data' => $data], function ($message) use ($data) {
                $message->to($data->email)->subject($data->subject);
            });
        } catch (\Swift_TransportException $ex) {
            return response()->json([
                'status' => 'error',
                'message' => "Mail sending Failed"
            ]);
        }
        if (count(Mail::failures()) > 0) {
            return response()->json([
                'status' => 'error',
                'message' => "Mail sending Failed"
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => "Mail sent Successfully"
            ]);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $email_subscriber = EmailSubscriber::find($id);
        if ($email_subscriber) {
            $email_subscriber->delete();
            return redirect()->route('backend.customers.index')->with($this->delete_success_message);
        } else {
            return back()->withInput()->with($this->not_found_message);
        }
    }
}
