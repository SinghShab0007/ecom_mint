@extends('backend.layouts.app')
@section('title', __('Payment') . ' - ')
@push('css')
    @include('backend.includes.datatable_css')
@endpush
@section('content')
    <div class="content-body">
        <div class="container">
            <div class="main-content default-manu">
                <div class="content-tab-title">
                    <h4>{{ __('Payment Management') }}</h4>
                </div>

                {{-- Overview --}}
                <div class="nav nav-tabs mb-4" id="nav-tab" role="tablist">
                    <div class="maan-counter-box active">
                        <div class="maan-icon maan-radius maan-icon-clr-lightdanger">
                            <i><img src="{{ asset('backend/img/icons/1.svg') }}" alt="Icon"></i>
                        </div>
                        <div class="maan-desc">
                            <div class="maan-counter">
                                <span class="maan-counter-title counter">{{ $overview['total_transactions'] ?? 0 }}</span>
                            </div>
                            <p class="maan-counter-content">{{ __('Total Transactions') }}</p>
                        </div>
                    </div>
                    <div class="maan-counter-box" onclick="location.href='{{ route('backend.payments.index', ['status' => 'paid']) }}'">
                        <div class="maan-icon maan-radius maan-icon-clr-lightgreen">
                            <i><img src="{{ asset('backend/img/icons/Confirmed-green.svg') }}" alt="Icon"></i>
                        </div>
                        <div class="maan-desc">
                            <div class="maan-counter">
                                <span class="maan-counter-title counter">{{ $overview['successful'] ?? 0 }}</span>
                            </div>
                            <p class="maan-counter-content">{{ __('Successful') }}</p>
                        </div>
                    </div>
                    <div class="maan-counter-box" onclick="location.href='{{ route('backend.payments.index', ['status' => 'pending']) }}'">
                        <div class="maan-icon maan-radius maan-icon-clr-lightyellow">
                            <i><img src="{{ asset('backend/img/icons/Processing.svg') }}" alt="Icon"></i>
                        </div>
                        <div class="maan-desc">
                            <div class="maan-counter">
                                <span class="maan-counter-title counter">{{ $overview['pending'] ?? 0 }}</span>
                            </div>
                            <p class="maan-counter-content">{{ __('Pending') }}</p>
                        </div>
                    </div>
                    <div class="maan-counter-box" onclick="location.href='{{ route('backend.payments.index', ['status' => 'failed']) }}'">
                        <div class="maan-icon maan-radius maan-icon-clr-lightred">
                            <i><img src="{{ asset('backend/img/icons/order-cancel.svg') }}" alt="Icon"></i>
                        </div>
                        <div class="maan-desc">
                            <div class="maan-counter">
                                <span class="maan-counter-title counter">{{ $overview['failed'] ?? 0 }}</span>
                            </div>
                            <p class="maan-counter-content">{{ __('Failed') }}</p>
                        </div>
                    </div>
                    <div class="maan-counter-box">
                        <div class="maan-icon maan-radius maan-icon-clr-lightblue1">
                            <i><img src="{{ asset('backend/img/icons/Delivered.svg') }}" alt="Icon"></i>
                        </div>
                        <div class="maan-desc">
                            <div class="maan-counter">
                                <span class="maan-counter-title">{{ currency($overview['total_amount_paid'] ?? 0, 2) }}</span>
                            </div>
                            <p class="maan-counter-content">{{ __('Total Amount Paid') }}</p>
                        </div>
                    </div>
                </div>

                {{-- Filters --}}
                <div class="mb-3">
                    <a href="{{ route('backend.payments.index') }}" class="btn btn-sm {{ empty($statusFilter) ? 'btn-primary' : 'btn-outline-secondary' }}">{{ __('All') }}</a>
                    <a href="{{ route('backend.payments.index', ['status' => 'paid']) }}" class="btn btn-sm {{ $statusFilter === 'paid' ? 'btn-success' : 'btn-outline-secondary' }}">{{ __('Successful') }}</a>
                    <a href="{{ route('backend.payments.index', ['status' => 'pending']) }}" class="btn btn-sm {{ $statusFilter === 'pending' ? 'btn-warning' : 'btn-outline-secondary' }}">{{ __('Pending') }}</a>
                    <a href="{{ route('backend.payments.index', ['status' => 'failed']) }}" class="btn btn-sm {{ $statusFilter === 'failed' ? 'btn-danger' : 'btn-outline-secondary' }}">{{ __('Failed') }}</a>
                    <a href="{{ route('backend.payments.index', ['status' => 'unpaid']) }}" class="btn btn-sm {{ $statusFilter === 'unpaid' ? 'btn-info' : 'btn-outline-secondary' }}">{{ __('Unpaid') }}</a>
                </div>

                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active">
                        <div class="content-table mt-0">
                            <table id="mDataTable" class="table p-table">
                                <thead>
                                <tr>
                                    <th scope="col">{{ __('Order #') }}</th>
                                    <th scope="col">{{ __('Date') }}</th>
                                    <th scope="col">{{ __('Customer') }}</th>
                                    <th scope="col">{{ __('Payment Method') }}</th>
                                    <th scope="col">{{ __('Amount') }}</th>
                                    <th scope="col">{{ __('Paid') }}</th>
                                    <th scope="col">{{ __('Status') }}</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    @include('backend.includes.datatable_js')
    <script>
        $(function() {
            "use strict";
            var statusFilter = "{{ $statusFilter }}";
            var ajaxUrl = "{{ route('backend.payments.list') }}" + (statusFilter ? "?status=" + encodeURIComponent(statusFilter) : "");
            $('#mDataTable').DataTable({
                ajax: ajaxUrl,
                columns: [
                    { data: 'order_no', name: 'order_no' },
                    { data: 'date', name: 'created_at' },
                    { data: 'customer', name: 'user_first_name' },
                    { data: 'payment_method', name: 'payment_by' },
                    { data: 'amount', name: 'total_price' },
                    { data: 'paid_amount', name: 'paid_amount' },
                    { data: 'payment_status', name: 'payment_status', orderable: false, searchable: false }
                ],
                order: [[1, 'desc']]
            });
        });
    </script>
@endpush
