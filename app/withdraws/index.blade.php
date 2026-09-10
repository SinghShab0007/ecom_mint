@extends('layouts.seller')
@section('title','Earning')
@push('css')
    @include('backend.includes.datatable_css')
@endpush
@section('content')
    <div class="content-body">
        <div class="container order-manu">
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <div class="maan-counter-box">
                        <div class="maan-icon maan-radius maan-icon-clr-lightdanger">
                            <i> <img src="{{ asset('icons/withdraw.png') }}" alt="Icon"></i>
                        </div>
                        <div class="maan-desc">
                            <div class="maan-counter">
                                <div class="maan-counter">
                                        <span class="count-icon">৳</span>
                                    <span class="maan-counter-title timer">{{ $total_withdraws }}</span>
                                </div>
                                <p class="maan-counter-content">{{ __('Total Withdraws') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="maan-counter-box">
                        <div class="maan-icon maan-radius maan-icon-clr-lightdanger">
                            <i> <img src="{{ asset('icons/success-withdraw.png') }}" alt="Icon"></i>
                        </div>
                        <div class="maan-desc">
                            <div class="maan-counter">
                                <div class="maan-counter">
                                        <span class="count-icon">৳</span>
                                    <span class="maan-counter-title timer">{{ $approved_withdraws }}</span>
                                </div>
                                <p class="maan-counter-content">{{ __('Approved Withdraws') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="maan-counter-box">
                        <div class="maan-icon maan-radius maan-icon-clr-lightblue">
                            <i> <img src="{{ asset('icons/pending-withdraw.png') }}" alt="Icon"></i>
                        </div>
                        <div class="maan-desc">
                            <div class="maan-counter">
                                <div class="maan-counter">
                                        <span class="count-icon">৳</span>
                                    <span class="maan-counter-title timer">{{ $pending_withdraws }}</span>
                                </div>
                                <p class="maan-counter-content">{{ __('Pending Withdraws') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="maan-counter-box">
                        <div class="maan-icon maan-radius maan-icon-clr-lightblue">
                            <i> <img src="{{ asset('icons/cancle-withdraw.png') }}" alt="Icon"></i>
                        </div>
                        <div class="maan-desc">
                            <div class="maan-counter">
                                <div class="maan-counter">
                                        <span class="count-icon">৳</span>
                                    <span class="maan-counter-title timer">{{ $rejected_withdraws }}</span>
                                </div>
                                <p class="maan-counter-content">{{ __('Rejected Withdraws') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mt-4">
            <h5 class="py-3">{{ __('Withdraws List') }}</h3>
            <div class="content-table mt-0">
                <table id="mDataTable" class="table p-table">
                    <thead>
                    <tr>
                        <th scope="col">{{ __('Trx Id') }}</th>
                        <th scope="col">{{ __('Account Holder') }}</th>
                        <th scope="col">{{ __('Account No.') }}</th>
                        <th scope="col">{{ __('Amount') }}</th>
                        <th scope="col">{{ __('Withdraw Date') }}</th>
                        <th scope="col">{{ __('Status') }}</th>
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
                    ajax: "{{route('seller.withdraws.data')}}",
                    columns: [
                        { data: 'trx_id'},
                        { data: 'account_holder'},
                        { data: 'account'},
                        { data: 'amount'},
                        { data: 'withdraw_date'},
                        { data: 'status'},
                    ]
                });
            });

        });
    </script>
@endpush
