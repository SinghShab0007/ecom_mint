@extends('backend.layouts.app')
@section('title','Shipped Orders - ')
@push('css')
    @include('backend.includes.datatable_css')
@endpush
@section('content')
    <div class="content-body">
    @include('ordermanagement::orders.order_overview')
    <!-- Tab Content Start -->
        <div class="tab-content order-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="shipped" role="tabpanel" aria-labelledby="shipped-tab">
                <div class="container">
                    <div class="content-table">
                        <table id="mDataTable" class="table p-table">
                            <thead>
                            <tr>
                                <th scope="col">{{ __('Invoice#') }}</th>
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('Items') }}</th>
                                <th scope="col">{{ __('Payment') }}</th>
                                <th scope="col">{{ __('Location') }}</th>
                                <th scope="col">{{ __('Amount') }}</th>
                                <th scope="col">{{ __('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tab Content End -->
    </div>
@endsection

@push('js')
    @include('backend.includes.datatable_js')
    <script>

        $(function() {
            "use strict";

            $(document).ready(function(){
                // DataTable
                var table = $('#mDataTable');
                table.DataTable({
                    ajax: "@auth('admin'){{route('backend.shipped_orders.list')}}@elseauth('seller'){{route('seller.shipped_orders.list')}}@endauth",
                    columns: [
                        { data: 'order_no' },
                        { data: 'user_last_name' },
                        { data: 'details_sum_qty'},
                        { data: 'payment_by' },
                        { data: 'user_address_1' },
                        { data: 'total_price' },
                        { data: 'action',searchable:false,sortable:false }
                    ]
                });
            });
        });
    </script>
@endpush
