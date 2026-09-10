@extends('backend.layouts.app')
@section('title','Promotion - ')
@push('css')
    @include('backend.includes.datatable_css')
@endpush
@section('content')
    <div class="content-body">
    @include('productmanagement::includes.promotion_nav')
    <!-- Tab Content Start -->
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="all-product" aria-labelledby="all-product-tab">
                <div class="container">

                    <div class="content-table mt-0">

                        <table id="mDataTable" class="table p-table">
                            <thead>
                            <tr>
                                <th scope="col">{{__('ID')}}</th>
                                <th scope="col">{{__('Title')}}</th>
                                <th scope="col">{{__('Position')}}</th>
                                <th scope="col">{{__('Image')}}</th>
                                <th scope="col">{{__('Product Name')}}</th>
                                <th scope="col">{{__('Expire At')}}</th>
                                <th scope="col">{{__('Approve')}}</th>
                                <th scope="col">{{__('Status')}}</th>
                                <th scope="col">{{__('Action')}}</th>
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
        $(function () {

            "use strict";

            $(document).ready(function(){
                // DataTable
                var table = $('#mDataTable');
                table.DataTable({
                    ajax: "@auth('admin'){{route('backend.promo_product.list')}}@elseauth('seller'){{route('seller.promo_product.list')}}@endauth",
                    columns: [
                        { data: 'id' },
                        { data: 'title' },
                        { data: 'position' },
                        { data: 'image',searchable:false,sortable:false },
                        { data: 'product_id' },
                        { data: 'expire_at' },
                        { data: 'is_approve' },
                        { data: 'is_active' },
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
                    url: public_path + @auth('admin')'/admin/promo_product/changeStatus'@elseauth('seller')'/seller/promo_product/changeStatus'@endauth,
                    data: {'status': status, 'id': id, 'field': 'is_active'},
                    success: function (data) {
                        notification('success', data.message);
                    }
                });
            });
            $(document).on('click', '#mDataTable .approve', function () {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: public_path + @auth('admin')'/admin/promo_product/changeStatus'@elseauth('seller')'/seller/promo_product/changeStatus'@endauth,
                    data: {'status': status, 'id': id, 'field': 'is_approve'},
                    success: function (data) {
                        notification('success', data.message);
                    }
                });
            });
        });
    </script>
@endpush
