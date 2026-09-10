@extends('layouts.seller')
@section('title','Earning')
@push('css')
    @include('backend.includes.datatable_css')
@endpush
@section('content')
    <div class="content-body">
        <div class="container order-manu">
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <div class="maan-counter-box">
                        <div class="maan-icon maan-radius maan-icon-clr-lightdanger">
                            <i> <img src="{{ asset('icons/total-earnings.png') }}" alt="Icon"></i>
                        </div>
                        <div class="maan-desc">
                            <div class="maan-counter">
                                <div class="maan-counter">
                                    <span class="count-icon">৳</span>
                                    <span class="maan-counter-title timer">{{ $total_earnings }}</span>
                                </div>
                                <p class="maan-counter-content">{{ __('Total Earning') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="maan-counter-box">
                        <div class="maan-icon maan-radius maan-icon-clr-lightdanger">
                            <i> <img src="{{ asset('icons/pending-earnings.png') }}" alt="Icon"></i>
                        </div>
                        <div class="maan-desc">
                            <div class="maan-counter">
                                <div class="maan-counter">
                                    <span class="count-icon">৳</span>
                                    <span class="maan-counter-title timer">{{ $total_unpaid }}</span>
                                </div>
                                <p class="maan-counter-content">{{ __('Total Unpaid Earning') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="maan-counter-box">
                        <div class="maan-icon maan-radius maan-icon-clr-lightblue">
                            <i> <img src="{{ asset('icons/paid-earnings.png') }}" alt="Icon"></i>
                        </div>
                        <div class="maan-desc">
                            <div class="maan-counter">
                                <div class="maan-counter">
                                    <span class="count-icon">৳</span>
                                    <span class="maan-counter-title timer">{{ $paid_earnings }}</span>
                                </div>
                                <p class="maan-counter-content">{{ __('Total Paid Earning') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mt-4">
            <h5 class="py-3">{{ __('Earnings List') }}</h3>
            <div class="content-table mt-0">
                <table id="mDataTable" class="table p-table">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('Order No.') }}</th>
                            <th scope="col">{{ __('Order Date') }}</th>
                            <th scope="col">{{ __('Item Sku') }}</th>
                            <th scope="col">{{ __('Price') }}</th>
                            <th scope="col">{{ __('Order Status') }}</th>
                            <th scope="col">{{ __('Payout Status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
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
                    ajax: "{{route('seller.earning.list')}}",
                    columns: [
                        { data: 'order_no' },
                        { data: 'order_date' },
                        { data: 'sku' },
                        { data: 'total_price' },
                        { data: 'order_status' },
                        { data: 'payout_status' },
                    ]
                });
            });

        });
    </script>
@endpush
