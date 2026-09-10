@extends('backend.layouts.app')
@section('title','Product Review - ')
@push('css')
    @include('backend.includes.datatable_css')
@endpush
@section('content')
    <div class="content-body">
        <div class="container">
            <div class="main-content default-manu">
            @include('backend.pages.content_management.nav')
                <!-- Tab Manu End  -->
                <!-- Tab Content Start -->
                <div class="tab-content default-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="product-review" aria-labelledby="product-review-tab">

                        <div class="content-table mt-0">
                            <table id="mDataTable" class="table p-table">
                                <thead>
                                <tr>
                                    <th scope="col">{{ __('ID') }}</th>
                                    <th scope="col">{{ __('Product Name') }}</th>
                                    <th scope="col">{{ __('Customer') }}</th>
                                    <th scope="col">{{ __('Point') }}</th>
                                    <th scope="col">{{ __('Comment') }}</th>
                                    <th scope="col">{{ __('Date') }}</th>
                                    <th scope="col">{{ __('Status') }}</th>
                                    <th scope="col">{{ __('Publish') }}</th>
                                    <th scope="col">{{ __('Action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Tab Content End  -->
            </div>
        </div>
    </div>
@endsection

@push('js')
    @include('backend.includes.datatable_js')
    <script>
        $(function () {

            "use strict";
            $(document).ready(function(){
                // DataTable
                var table = $('#mDataTable');
                table.DataTable({
                    ajax: "@auth('admin'){{route('backend.product_review.list')}}@elseauth('seller'){{route('seller.product_review.list')}}@endauth",
                    columns: [
                        { data: 'id'},
                        { data: 'product_name' },
                        { data: 'customer_name'},
                        { data: 'review_point' },
                        { data: 'review_note' },
                        { data: 'created_at' },
                        { data: 'is_active' },
                        { data: 'publish_stat' },
                        { data: 'action',searchable:false,sortable:false },
                    ]
                });

            });

            $(document).on('click', '#mDataTable .status', function () {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: public_path + @auth('admin')'/admin/product_review/changeStatus'@elseauth('seller')'/seller/product_review/changeStatus'@endauth,
                    data: {'status': status, 'id': id, 'field': 'is_active'},
                    success: function (data) {
                        notification('success', data.message);
                    }
                });
            });
            $(document).on('click', '#mDataTable .publish', function () {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: public_path + @auth('admin')'/admin/product_review/changeStatus'@elseauth('seller')'/seller/product_review/changeStatus'@endauth,
                    data: {'status': status, 'id': id, 'field': 'publish_stat'},
                    success: function (data) {
                        notification('success', data.message);
                    }
                });
            });
        });
    </script>
@endpush
