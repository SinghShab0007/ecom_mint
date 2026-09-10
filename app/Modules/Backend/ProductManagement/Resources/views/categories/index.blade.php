@extends('backend.layouts.app')
@section('title','Category - ')
@push('css')
    @include('backend.includes.datatable_css')
@endpush
@section('content')
    <div class="content-body">
    @include('productmanagement::includes.product_management')
        <!-- Tab Content Start -->
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="category" role="tabpanel" aria-labelledby="category-tab">
                <div class="container">

                    <div class="content-table mt-0">
                        <table id="mDataTable" class="table p-table">
                            <thead>
                            <tr>
                                <th scope="col">{{ __('Id') }}</th>
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('Image') }}</th>
                                <th scope="col">{{ __('Parent') }}</th>
                                <th scope="col">{{ __('Display') }}</th>
                                <th scope="col">{{ __('Sort') }}</th>
                                <th scope="col">{{ __('Status') }}</th>
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
            $(document).on('click','#mDataTable .status', function() {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var cat_id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: public_path +@auth('admin')'/admin/category/changeStatus'@elseauth('seller')'/seller/category/changeStatus'@endauth,
                    data: {'status': status, 'cat_id': cat_id,'field': 'is_active'},
                    success: function(data){
                        notification('success', data.message);
                    }
                });
            });
            $(document).on('click','#mDataTable .display_out_website', function() {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var cat_id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: public_path +@auth('admin')'/admin/category/changeStatus'@elseauth('seller')'/seller/category/changeStatus'@endauth,
                    data: {'status': status, 'cat_id': cat_id,'field': 'show_in_home'},
                    success: function(data){
                        notification('success', data.message);
                    }
                });
            });

            $(document).ready(function(){
                // DataTable
                var table = $('#mDataTable');
                table.DataTable({
                    ajax: "@auth('admin'){{route('backend.category.list')}}@elseauth('seller'){{route('seller.category.list')}}@endauth",
                    columns: [
                        { data: 'id' },
                        { data: 'name' },
                        { data: 'image',searchable:false,sortable:false },
                        { data: 'category_id' },
                        { data: 'show_in_home' },
                        { data: 'order' },
                        { data: 'is_active' },
                        { data: 'action',searchable:false,sortable:false },
                    ]
                });

            });
        });
    </script>
@endpush
