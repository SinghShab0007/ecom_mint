@extends('backend.layouts.app')
@section('title','Announcements - ')
@push('css')
    @include('backend.includes.datatable_css')
@endpush
@section('content')
    <div class="content-body">
        <div class="container">
            <div class="main-content default-manu">
            @include('backend.pages.website_setting.nav')
            <!-- Tab Manu End  -->
                <!-- Tab Content Start -->
                <div class="tab-content default-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="pages" aria-labelledby="pages-tab">
                        <div class="row">
                            <div class="col">
                                <div class="float-md-end">
                                    <a href="{{route('backend.announcements.create')}}">
                                        <button class="btn btn-warning pull-right"> {{ __('Add Announcements') }}</button>
                                    </a>

                                </div>
                            </div>
                        </div>
                        <div class="content-table">
                            <table id="mDataTable" class="table p-table">
                                <thead>
                                <tr>
                                    <th scope="col">{{ __('Id') }}</th>
                                    <th scope="col">{{ __('title') }}</th>
                                    <th scope="col">{{ __('Thumbnail') }}</th>
                                    <th scope="col">{{ __('Description') }}</th>
                                    <th scope="col">{{ __('Sale Price') }}</th>
                                    <th scope="col">{{ __('Old Price') }}</th>
                                    <th scope="col">{{ __('Expire At') }}</th>
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
                <!-- Tab Content End  -->
            </div>
        </div>
    </div>
@endsection

@push('js')
    @include('backend.includes.datatable_js')
    <script>
        $(document).ready(function(){
            "use strict";
            // DataTable
            var table = $('#mDataTable');
            table.DataTable({
                ajax: "{{route('backend.announcements.list')}}",
                columns: [
                    { data: 'id' },
                    { data: 'title' },
                    { data: 'thumbnail' },
                    { data: 'description' },
                    { data: 'sale_price' },
                    { data: 'old_price' },
                    { data: 'expire_at' },
                    { data: 'is_active' },
                    { data: 'action',searchable:false,sortable:false },
                ]
            });
            $(document).on('click', '#mDataTable .status', function () {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: public_path + '/admin/announcements/changeStatus',
                    data: {'status': status, 'id': id, 'field': 'is_active'},
                    success: function (data) {
                        notification('success', data.message);
                    }
                });
            });
        });
    </script>
@endpush
