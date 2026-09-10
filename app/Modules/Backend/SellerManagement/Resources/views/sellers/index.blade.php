@extends('backend.layouts.app')
@section('title','Sellers - ')
@push('css')
    @include('backend.includes.datatable_css')
@endpush
@section('content')
    <div class="content-body">
        @include('sellermanagement::includes.tab_menu')
        <!-- Tab Content Start -->
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="seller-list" aria-labelledby="seller-list-tab">
                <div class="container">
                    <div class="content-table mt-0">
                        <table id="mDataTable" class="table p-table">
                            <thead>
                            <tr>
                                <th scope="col">{{__('Shop')}}</th>
                                <th scope="col">{{__('Seller')}}</th>
                                <th scope="col">{{__('Phone')}}</th>
                                <th scope="col">{{__('Email')}}</th>
                                <th scope="col">{{__('Status')}}</th>
                                <th scope="col">{{__('Approval')}}</th>
                                <th scope="col">{{__('Products')}}</th>
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
        $(function() {

            "use strict";
            $(document).ready(function(){
                // DataTable
                var table = $('#mDataTable');
                table.DataTable({
                    ajax: "{{route('backend.seller.list')}}",
                    columns: [
                        { data: 'company_name' },
                        { data: 'last_name' },
                        { data: 'mobile' },
                        { data: 'email'},
                        { data: 'is_active' },
                        { data: 'is_approve' },
                        { data: 'product_id',searchable:false,sortable:false },
                        { data: 'action',searchable:false,sortable:false },
                    ]
                });

            });

            $(document).on('click','#mDataTable .status', function() {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: public_path +'/admin/seller/changeStatus',
                    data: {'status': status, 'id': id,'field': 'is_active'},
                    success: function(data){
                        notification('success', data.message);
                    }
                });
            });
            $(document).on('click','#mDataTable .approve', function() {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: public_path + '/admin/seller/approve',
                    data: {'status': status, 'id': id, 'field': 'is_approve'},
                    success: function (data) {
                        notification('success', data.message);
                    }
                });
            })
        });
    </script>
@endpush
