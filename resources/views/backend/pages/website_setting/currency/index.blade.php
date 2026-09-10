@extends('backend.layouts.app')
@section('title','Currency - ')
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
                                    <a href="{{route('backend.currency.create')}}">
                                        <button class="btn btn-warning pull-right"> {{ __('Add Currency') }}</button>
                                    </a>

                                </div>
                            </div>
                        </div>
                        <div class="content-table">
                            <table id="mDataTable" class="table p-table">
                                <thead>
                                <tr>
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col">{{ __('CC') }}</th>
                                    <th scope="col">{{ __('Symbol') }}</th>
                                    <th scope="col">{{ __('Exchange Rate') }}</th>
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
                ajax: "{{route('backend.currency.list')}}",
                columns: [
                    { data: 'name' },
                    { data: 'cc' },
                    { data: 'symbol' },
                    { data: 'exchange_rate' },
                    { data: 'is_active' },
                    { data: 'action',searchable:false,sortable:false },
                ],
                "order": [[ 4, "desc" ]]
            });
            $(document).on('click', '#mDataTable .status', function () {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: public_path + '/admin/currency/changeStatus',
                    data: {'status': status, 'id': id, 'field': 'is_active'},
                    success: function (data) {
                        notification('success', data.message);
                    }
                });
            });
        });
    </script>
@endpush
