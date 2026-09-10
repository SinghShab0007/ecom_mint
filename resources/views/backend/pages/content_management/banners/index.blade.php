@extends('backend.layouts.app')
@section('title','Banner - ')
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
                    <div class="tab-pane fade show active" id="banner" aria-labelledby="banner-tab">
                        <div class="row">
                            <div class="col">
                                <div class="float-md-end">
                                    @if(auth()->user()->can('create_banners') || auth()->user()->hasRole('super-admin'))
                                    <a href="@auth('admin'){{route('backend.banners.create')}}@elseauth('seller'){{route('seller.banners.create')}}@endauth">
                                        <button class="btn btn-warning pull-right"> {{ __('Add Banner') }}</button>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="content-table">
                            <table id="mDataTable" class="table p-table">
                                <thead>
                                <tr>
                                    <th scope="col">{{ __('Image') }}</th>
                                    <th scope="col">{{ __('Title') }}</th>
                                    <th scope="col">{{ __('Click') }}</th>
                                    <th scope="col">{{ __('Target') }}</th>
                                    <th scope="col">{{ __('Type') }}</th>
                                    <th scope="col">{{ __('Expire') }}</th>
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
                    ajax: "@auth('admin'){{route('backend.banner.list')}}@elseauth('seller'){{route('seller.banner.list')}}@endauth",
                    columns: [
                        { data: 'image', searchable:false,sortable:false },
                        { data: 'title' },
                        { data: 'total_click'},
                        { data: 'target' },
                        { data: 'type' },
                        { data: 'expire_at' },
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
                    url: public_path + @auth('admin')'/admin/banner/changeStatus'@elseauth('seller')'/seller/banner/changeStatus'@endauth,
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
                    url: public_path + @auth('admin')'/admin/banner/changeStatus'@elseauth('seller')'/seller/banner/changeStatus'@endauth,
                    data: {'status': status, 'id': id, 'field': 'publish_stat'},
                    success: function (data) {
                        notification('success', data.message);
                    }
                });
            });
        });
    </script>
@endpush
