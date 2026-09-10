@extends('backend.layouts.app')
@section('title','Seller Report - ')
@push('css')
    @include('backend.includes.datatable_css')
@endpush
@section('content')
    <div class="content-body">
    @include('backend.pages.reports.nav')
    <!-- Tab Content Start -->
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="seller-report" aria-labelledby="seller-report-tab">
                <div class="container">
                    <div class="content-table mt-0">
                        <table id="mDataTable" class="table p-table">
                            <thead>
                            <tr>
                                <th scope="col">{{ __('Invoice#') }}</th>
                                <th scope="col">{{ __('Seller') }}</th>
                                <th scope="col">{{ __('Phone') }}</th>
                                <th scope="col">{{ __('Email') }}</th>
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
                    ajax: "{{route('backend.seller_report.list')}}",
                    columns: [
                        { data: 'order_no' },
                        { data: 'company_name' },
                        { data: 'mobile' },
                        { data: 'email' },
                    ]
                });
            });

        });
    </script>
@endpush
