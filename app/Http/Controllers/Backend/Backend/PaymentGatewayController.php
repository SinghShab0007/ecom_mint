<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseMessage;
use App\Models\Frontend\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mockery\CountValidator\Exception;

class PaymentGatewayController extends Controller
{

    use ResponseMessage;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payment_gateways = PaymentGateway::all();
        return view('backend.pages.payment_gateway.index',compact('payment_gateways'));
    }

    /* change status*/
    public function changeStatus(Request $request)
    {
        $payment_gateway = Banner::findOrFail($request->id);
        if ($payment_gateway) {
            if ($request->field == 'status')
                $payment_gateway->status = $request->status;
            $payment_gateway->save();
            return response()->json($this->update_success_message);
        } else {
            return response()->json($this->not_found_message);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'configuration' => 'required|array',
                'status' => 'required',
            ]);
            $payment_gateway = PaymentGateway::findOrFail($id);
            if ($payment_gateway) {
                $data = $request->only('status');
                $data['configuration'] = json_encode($request->input('configuration'));
                $payment_gateway->update($data);
                    return redirect()->route('backend.payment_gateway.index')->with($this->update_success_message);
            } else {
                return back()->withInput()->with($this->update_fail_message);
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return back()->withInput()->with($this->update_fail_message);
        }
    }

}
