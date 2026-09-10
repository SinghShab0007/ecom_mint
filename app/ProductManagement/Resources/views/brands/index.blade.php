@extends('backend.layouts.app')
@section('title','Brands - ')
@push('css')
    @include('backend.includes.datatable_css')
@endpush
@section('content')
    <div class="content-body">
    @include('productmanagement::includes.product_management')
        <!-- Tab Content Start -->
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="brand" role="tabpanel" aria-labelledby="brand-tab">
                <div class="container">
                    <div class="content-table mt-0">
                        <table id="mDataTable" class="table p-table">
                            <thead>
                            <tr>
                                <th scope="col">{{ __('ID') }}</th>
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('Logo') }}</th>
                                <th scope="col">{{ __('Slug') }}</th>
                                <th scope="col">{{ __('Order') }}</th>
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

            $(document).ready(function(){
                // DataTable
                var table = $('#mDataTable');
                table.DataTable({
                    ajax: "@auth('admin'){{route('backend.brand.list')}}@elseauth('seller'){{route('seller.brand.list')}}@endauth",
                    columns: [
                        { data: 'id' },
                        { data: 'name' },
                        { data: 'logo',searchable:false,sortable:false },
                        { data: 'slug' },
                        { data: 'order' },
                        { data: 'is_active' },
                        { data: 'action',searchable:false,sortable:false },
                    ]
                });

            });

            $(document).on('click','#mDataTable .status', function() {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var brand_id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: public_path +@auth('admin')'/admin/brand/changeStatus'@elseauth('seller')'/seller/brand/changeStatus'@endauth,
                    data: {'status': status, 'brand_id': brand_id,'field': 'is_active'},
                    success: function(data){
                        notification('success', data.message);
                    }
                });
            });
        });
    </script>
@endpush
