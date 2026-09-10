@extends('backend.layouts.app')
@section('title','Confirmed Orders - ')
@push('css')
    @include('backend.includes.datatable_css')
@endpush
@section('content')
    <div class="content-body">
    @include('ordermanagement::orders.order_overview')
    <!-- Tab Content Start -->
        <div class="tab-content order-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="confirmed" role="tabpanel" aria-labelledby="confirmed-tab">
                <div class="container">
                    <div class="content-table">
                        <table id="mDataTable" class="table p-table">
                            <thead>
                            <tr>
                                <th scope="col">{{ __('Invoice#') }}</th>
                                <th scope="col">{{ __('Customer') }}</th>
                                <th scope="col">{{ __('Items') }}</th>
                                <th scope="col">{{ __('Payment') }}</th>
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
                    ajax: "@auth('admin'){{route('backend.confirmed_orders.list')}}@elseauth('seller'){{route('seller.confirmed_orders.list')}}@endauth",
                    columns: [
                        { data: 'order_no' },
                        { data: 'created_by' },
                        { data: 'details_sum_qty'},
                        { data: 'payment_by' },
                        { data: 'action',searchable:false,sortable:false },
                    ]
                });
            });
        });
    </script>
@endpush
