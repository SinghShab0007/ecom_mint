<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Http\Traits\ResponseMessage;
use App\Models\Api\OrderDetail;
use App\Models\Api\Order;
use App\Models\Api\OrderTimeline;
use Dompdf\Dompdf;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use ApiResponse, ResponseMessage;

    public function __construct()
    {

    }

    public function index()
    {
        $orders = Order::with('details')->where('user_id', auth('api')->id())->paginate(request('per_page', 10));

        return $this->successResponse($orders, $this->load_success['message']);
    }

    public function invoice($id)
    {
        $order = Order::query()->where('user_id', auth('api')->id())->find($id);
        if ($order) {
            return $this->successResponse($order, $this->load_success['message']);
        } else {
            return $this->errorResponse($this->not_found_message['message']);
        }

    }

    public function invoiceDownload($id)
    {
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('customer.pdf.invoice'));

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream();
    }

    public function details($id)
    {
        $order = OrderDetail::query()->with('product', 'timelines')->where('user_id', auth('api')->id())->find($id);
        if ($order) {
            return $this->successResponse($order, $this->load_success['message']);
        } else {
            return $this->errorResponse($this->not_found_message['message']);
        }
    }

    public function timelines($id)
    {
        $timelines = OrderTimeline::query()->with('status')->where('user_id', auth('api')->id())
            ->where('order_detail_id', $id)->select('order_stat','order_stat_desc','remarks','order_stat_datetime')->latest()->get();
        if ($timelines) {
            return $this->successResponse($timelines, $this->load_success['message']);
        } else {
            return $this->errorResponse($this->not_found_message['message']);
        }
    }

    public function orderStatus($id)
    {
        $timeline = OrderTimeline::query()->with('status')->where('user_id', auth('api')->id())->where('order_detail_id', $id)->latest()->first();
        if ($timeline) {
            return $this->successResponse($timeline->status, $this->load_success['message']);
        } else {
            return $this->errorResponse($this->not_found_message['message']);
        }
    }

    public function cancelledOrderList(Request $request)
    {
        $orders = OrderDetail::with('order')->where('user_id', auth('api')->id())->where('order_stat', 7)->paginate(request('per_page', 10));

        return $this->successResponse($orders, $this->load_success['message']);

    }

    public function list(Request $request)
    {
        $request->validate([
            'search' => 'required'
        ]);

        $order = Order::query();

        if ($request->has('stat')) {
            $stat = $request->get('stat');
            if ($stat > 0) {
                $order->whereHas('items', function ($query) use ($stat) {
                    $query->where('order_stat', $stat);
                });
            }
        }

        if ($request->has('search')) {
            $searchValue = $request->get('search');
            $order
                ->where('user_id', auth('api')->id())
                ->where('order_no', 'like', '%' . $searchValue . '%');
        }

        $orders = $order->latest()->paginate(request('per_page', 10));

        return $this->successResponse($orders, $this->load_success['message']);

    }

    public function cancelOrder(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'order_details_id' => 'required',
            'product_id' => 'required',
            'order_stat_desc' => 'required',
        ]);

        try {
            $order = Order::where('id', $request->input('order_id'))->where('user_id', auth('api')->id())->first();
            if ($order) {

                $order_details = OrderDetail::where('id', $request->order_details_id)->where('user_id', auth('api')->id())->first();

                $data = [
                    'order_detail_id' => $request->input('orders_details_id'),
                    'user_id' => auth('api')->id(),
                    'product_id' => $request->input('product_id'),
                    'order_stat' => 7,
                    'order_stat_desc' => $request->order_stat_desc,
                    'order_stat_datetime' => now(),
                    'remarks' => $request->remarks ?? '',
                ];

                if ($order_details) {
                    $order->update(['total_price' => ($order->total_price - $order_details->total_price)]);
                    $order->update(['shipping_cost' => ($order->shipping_cost - $order_details->total_shipping_cost)]);
                    $order_details->update(['order_stat' => 7]);
                    OrderTimeline::query()->create($data);
                }
                return $this->successResponse('', $this->update_success_message['message']);
            } else {
                return $this->errorResponse($this->not_found_message['message']);
            }
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage());
        }
    }
}
