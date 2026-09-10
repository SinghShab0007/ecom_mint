@extends('backend.layouts.app')
@section('title','Customer Report - ')
@push('css')
    @include('backend.includes.datatable_css')
@endpush
@section('content')
    <div class="content-body">
        @include('backend.pages.reports.nav')
        <!-- Tab Content Start -->
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="order-report" aria-labelledby="order-report-tab">
                <div class="container">
                    <div class="content-table mt-0">
                        <table id="mDataTable" class="table p-table">
                            <thead>
                            <tr>
                                <th scope="col">{{ __('Invoice#') }}</th>
                                <th scope="col">{{ __('Customer') }}</th>
                                <th scope="col">{{ __('Phone') }}</th>
                                <th scope="col">{{ __('Email') }}</th>
                                <th scope="col">{{ __('Location') }}</th>
                                <th scope="col">{{ __('Quantity') }}</th>
                                <th scope="col">{{ __('Amount') }}</th>
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
            $.extend( $.fn.dataTable.defaults, {
                buttons: [
                    {
                        extend: 'collection',
                        text: 'Export',
                        buttons: [
                            {
                                extend: 'copy',
                                text: 'copy',
                                exportOptions: {
                                }
                            },
                            {
                                extend: 'excel',
                                text: 'excel',
                                exportOptions: {
                                }
                            },
                            {
                                extend: 'csv',
                                text: 'csv',
                                exportOptions: {
                                    columns: 'th:not(:last-child)'
                                }
                            },
                            {
                                extend: 'pdf',
                                text: 'pdf',
                                exportOptions: {
                                }
                            },
                            {
                                extend: 'print',
                                text: 'print',
                                exportOptions: {
                                }
                            }
                        ]
                    }
                ]
            } );
            $(document).ready(function(){
                // DataTable
                var table = $('#mDataTable');
                table.DataTable({
                    ajax: "@auth('admin'){{route('backend.customer_report.list')}}@elseauth('seller'){{route('seller.customer_report.list')}}@endauth",
                    columns: [
                        { data: 'order_no' },
                        { data: 'last_name' },
                        { data: 'mobile' },
                        { data: 'email' },
                        { data: 'shipping_address_1' },
                        { data: 'details_sum_qty' },
                        { data: 'total_price' },
                    ]
                });
            });

        });
    </script>
@endpush
