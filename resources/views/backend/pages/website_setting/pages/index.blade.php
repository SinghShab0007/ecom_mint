@extends('backend.layouts.app')
@section('title','Website Pages - ')
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
                        <div class="content-table">
                            <table id="mDataTable" class="table p-table">
                                <thead>
                                <tr>
                                    <th scope="col">{{ __('Menu Name') }}</th>
                                    <th scope="col">{{ __('Url') }}</th>
                                    <th scope="col">{{ __('Target') }}</th>
                                    <th scope="col">{{ __('Is Header') }}</th>
                                    <th scope="col">{{ __('Is Footer') }}</th>
                                    <th scope="col">{{ __('Is Quick Link') }}</th>
                                    <th scope="col">{{ __('Is Informatic') }}</th>
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
                ajax: "{{route('backend.website_setting.page.list')}}",
                columns: [
                    { data: 'name' },
                    { data: 'url' },
                    { data: 'target' },
                    { data: 'is_header_menu' },
                    { data: 'is_footer_menu' },
                    { data: 'is_quick_link' },
                    { data: 'is_informatics' },
                    { data: 'is_active' },
                    { data: 'action',searchable:false,sortable:false },
                ]
            });


            $(document).on('click', '#mDataTable .header', function () {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: public_path + '/admin/website_setting/changeMenuStatus',
                    data: {'status': status,'id':id, 'field': 'is_header_menu'},
                    success: function (data) {
                        notification('success', data.message);
                    }
                });
            });
            $(document).on('click', '#mDataTable .footer', function () {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: public_path + '/admin/website_setting/changeMenuStatus',
                    data: {'status': status,'id':id, 'field': 'is_footer_menu'},
                    success: function (data) {
                        notification('success', data.message);
                    }
                });
            });
            $(document).on('click', '#mDataTable .quick_link', function () {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: public_path + '/admin/website_setting/changeMenuStatus',
                    data: {'status': status,'id':id, 'field': 'is_quick_link'},
                    success: function (data) {
                        notification('success', data.message);
                    }
                });
            });
            $(document).on('click', '#mDataTable .informatic', function () {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: public_path + '/admin/website_setting/changeMenuStatus',
                    data: {'status': status,'id':id, 'field': 'is_informatic'},
                    success: function (data) {
                        notification('success', data.message);
                    }
                });
            });
            $(document).on('click', '#mDataTable .status', function () {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: public_path + '/admin/website_setting/changeMenuStatus',
                    data: {'status': status,'id':id, 'field': 'is_active'},
                    success: function (data) {
                        notification('success', data.message);
                    }
                });
            });

        });
    </script>
@endpush
