<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Frontend\Order;
use Illuminate\Http\Request;

class PaymentManagementController extends Controller
{
    /**
     * Payment overview and list page.
     */
    public function index(Request $request)
    {
        $overview = $this->paymentOverview();
        $statusFilter = $request->get('status', '');
        return view('backend.pages.payments.index', compact('overview', 'statusFilter'));
    }

    /**
     * Overview counts: total transactions, successful (paid), pending, failed.
     */
    protected function paymentOverview(): array
    {
        $query = Order::query();
        $total = (clone $query)->count();

        $successful = (clone $query)->where('payment_status', 'paid')->count();
        $pending = (clone $query)->where('payment_status', 'pending')->count();
        $failed = (clone $query)->where('payment_status', 'failed')->count();
        $unpaid = (clone $query)->where('payment_status', 'unpaid')->count();

        $totalAmountPaid = (float) Order::query()->where('payment_status', 'paid')->sum('paid_amount');

        return [
            'total_transactions' => $total,
            'successful'        => $successful,
            'pending'           => $pending,
            'failed'            => $failed,
            'unpaid'            => $unpaid,
            'total_amount_paid' => $totalAmountPaid,
        ];
    }

    /**
     * DataTables AJAX: list payments (orders with payment info).
     */
    public function paymentList(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $rowperpage = $request->get('length');
        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = isset($columnIndex_arr[0]['column']) ? $columnIndex_arr[0]['column'] : 0;
        $columnName = isset($columnName_arr[$columnIndex]['data']) ? $columnName_arr[$columnIndex]['data'] : 'created_at';
        $columnSortOrder = isset($order_arr[0]['dir']) ? $order_arr[0]['dir'] : 'desc';
        $searchValue = $search_arr['value'] ?? '';

        $query = Order::query()->latest();

        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }

        $totalRecords = $query->count();

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('order_no', 'like', '%' . $searchValue . '%')
                    ->orWhere('user_first_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('user_last_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('user_mobile', 'like', '%' . $searchValue . '%')
                    ->orWhere('user_email', 'like', '%' . $searchValue . '%')
                    ->orWhere('payment_by', 'like', '%' . $searchValue . '%')
                    ->orWhere('payment_status', 'like', '%' . $searchValue . '%');
            });
        }
        $totalRecordswithFilter = $query->count();

        $sortMap = [
            'customer' => 'user_first_name',
            'amount' => 'total_price',
            'date' => 'created_at',
            'payment_method' => 'payment_by',
            'order_no' => 'order_no',
            'paid_amount' => 'paid_amount',
        ];
        $sortColumn = $sortMap[$columnName] ?? 'created_at';
        $records = $query
            ->orderBy($sortColumn, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = [];
        foreach ($records as $record) {
            $statusBadge = $this->statusBadge($record->payment_status);
            $customer = trim(($record->user_first_name ?? '') . ' ' . ($record->user_last_name ?? ''));
            $amount = $record->total_price + $record->shipping_cost - ($record->coupon_discount ?? 0);
            $show_route = route('backend.orders.show', $record->id);

            $data_arr[] = [
                'order_no'        => '<a href="' . $show_route . '"><span class="text-primary">' . e($record->order_no) . '</span></a>',
                'date'            => $record->created_at ? \Carbon\Carbon::parse($record->created_at)->format('d M Y H:i') : '—',
                'customer'        => e($customer ?: '—'),
                'payment_method'  => e($record->payment_by ?? '—'),
                'amount'          => number_format($amount, 2),
                'paid_amount'     => number_format((float) ($record->paid_amount ?? 0), 2),
                'payment_status'  => $statusBadge,
            ];
        }

        return response()->json([
            'draw' => (int) $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecordswithFilter,
            'data' => $data_arr,
        ]);
    }

    protected function statusBadge(?string $status): string
    {
        $status = $status ?? 'unpaid';
        $class = 'secondary';
        if ($status === 'paid') {
            $class = 'success';
        } elseif ($status === 'pending') {
            $class = 'warning';
        } elseif ($status === 'failed') {
            $class = 'danger';
        } elseif ($status === 'unpaid') {
            $class = 'info';
        }
        return '<span class="badge bg-' . $class . '">' . e(ucfirst($status)) . '</span>';
    }
}
