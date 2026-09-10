@extends('backend.layouts.app')
@section('title','Product - ')
@push('css')
    @include('backend.includes.datatable_css')
@endpush
@section('content')
    <div class="content-body">
        @include('productmanagement::includes.flash_deal_management')
        <!-- Tab Content Start -->
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="all-product" aria-labelledby="all-product-tab">
                <div class="container">

                    <div class="content-table mt-0">

                        <table id="mDataTable" class="table p-table">
                            <thead>
                            <tr>
                                <th scope="col">{{__('ID')}}</th>
                                <th scope="col">{{__('Name')}}</th>
                                <th scope="col">{{__('Image')}}</th>
                                <th scope="col">{{__('Price')}}</th>
                                <th scope="col">{{__('Stock')}}</th>
                                <th scope="col">{{__('Sold')}}</th>
                                <th scope="col">{{__('Viewed')}}</th>
                                <th scope="col">{{__('Status')}}</th>
                                <th scope="col">{{__('Start Date')}}</th>
                                <th scope="col">{{__('End Date')}}</th>

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
                    ajax: "@auth('admin'){{route('backend.product.flash-deal-list')}}@elseauth('seller'){{route('seller.product.flash-deal-list')}}@endauth",
                    columns: [
                        { data: 'id' },
                        { data: 'name' },
                        { data: 'image',searchable:false,sortable:false },
                        { data: 'unit_price' },
                        { data: 'quantity' },
                        { data: 'sold',searchable:false,sortable:false},
                        { data: 'total_viewed' },
                        { data: 'is_active' },
                        { data: 'start_date' },
                        { data: 'end_date' },
                    ]
                });

            });

            $(document).on('click','#mDataTable .status', function() {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: public_path +@auth('admin')'/admin/product/flashDealchangeStatus'@elseauth('seller')'/seller/product/flashDealchangeStatus'@endauth,
                    data: {'status': status, 'id': id,'field': 'is_active'},
                    success: function(data){
                        notification('success', data.message);
                    }
                });
            });
        });
    </script>
@endpush
