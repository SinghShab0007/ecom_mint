@extends('backend.layouts.app')
@section('title','Stock Report - ')
@push('css')
    @include('backend.includes.datatable_css')
@endpush
@section('content')
    <div class="content-body">
        @include('backend.pages.reports.nav')
        <!-- Tab Content Start -->
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="stock-report" aria-labelledby="stock-report-tab">
                <div class="container">
                    <div class="content-table mt-0">
                        <table id="mDataTable" class="table p-table">
                            <thead>
                            <tr>
                                <th scope="col">{{ __('Product Name') }}</th>
                                <th scope="col">{{ __('Image') }}</th>
                                <th scope="col">{{ __('Sku') }}</th>
                                <th scope="col">{{ __('Price') }}</th>
                                <th scope="col">{{ __('Stock') }}</th>
                                <th scope="col">{{ __('Sold') }}</th>
                                <th scope="col">{{ __('Viewed') }}</th>
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
                                    // columns: 'th:not(:last-child)'
                                }
                            },
                            {
                                extend: 'excel',
                                text: 'excel',
                                exportOptions: {
                                    // columns: 'th:not(:last-child)'
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
                                    // columns: 'th:not(:last-child)'
                                }
                            },
                            {
                                extend: 'print',
                                text: 'print',
                                exportOptions: {
                                    // columns: 'th:not(:last-child)'
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
                    ajax: "@auth('admin'){{route('backend.stock_report.list')}}@elseauth('seller'){{route('seller.stock_report.list')}}@endauth",
                    columns: [
                        { data: 'name' },
                        { data: 'image',searchable:false,sortable:false },
                        { data: 'sku' },
                        { data: 'unit_price' },
                        { data: 'quantity' },
                        { data: 'orders_sum_qty' },
                        { data: 'total_viewed' },
                    ]
                });
            });

        });
    </script>
@endpush
