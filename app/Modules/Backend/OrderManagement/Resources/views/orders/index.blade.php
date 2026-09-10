@extends('backend.layouts.app')
@section('title','Orders - ')
@push('css')
    @include('backend.includes.datatable_css')
@endpush
@section('content')
    <div class="content-body">
    @include('ordermanagement::orders.order_overview')
    <!-- Tab Content Start -->
        <div class="tab-content order-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="order-list" aria-labelledby="order-list-tab">
                <div class="container">

                    <div class="content-table mt-0">
                        <table id="mDataTable" class="table p-table">
                            <thead>
                            <tr>
                                <th scope="col">{{ __('Invoice#') }}</th>
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('Shipping') }}</th>
                                <th scope="col">{{ __('Discount') }}</th>
                                <th scope="col">{{ __('Coupon Discount') }}</th>
                                <th scope="col">{{ __('Total') }}</th>
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
                    ajax: "@auth('admin'){{route('backend.orders.list')}}@elseauth('seller'){{route('seller.orders.list', ['order_no' => request('order')])}}@endauth",
                    columns: [
                        { data: 'order_no' },
                        { data: 'user_last_name' },
                        { data: 'shipping_address_1'},
                        { data: 'discount' },
                        { data: 'coupon_discount' },
                        { data: 'total_price' },
                        { data: 'payment_by' },
                        { data: 'action',searchable:false,sortable:false },
                    ]
                });
                let method = "<?php echo Route::getCurrentRoute()->getName(); ?>";
                if(method == 'backend.search'){
                    let searchValue = "<?php echo $searchValue; ?>";
                    table.DataTable().search(searchValue).draw();
                }
                else if(method == 'seller.search'){
                    let searchValue = "<?php echo $searchValue; ?>";
                    table.DataTable().search(searchValue).draw();
                }

            });
        });
    </script>
@endpush
