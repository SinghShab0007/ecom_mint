@extends('backend.layouts.app')
@section('title','Users - ')
@push('css')
    @include('backend.includes.datatable_css')
@endpush
@section('content')
    <div class="content-body">
        @include('backend.pages.user_permission.nav')
        <!-- Tab Content Start -->
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="users" role="tabpanel" aria-labelledby="users-tab">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <a href="{{route('backend.users.create')}}" methods="get" class="float-end">
                                <button class="btn theme-btn">{{ __('Add User') }}</button>
                            </a>
                        </div>
                    </div>
                    <div class="content-table">
                        <table id="mDataTable" class="table p-table">
                            <thead>
                            <tr>
                                <th scope="col">{{ __('Serial') }}</th>
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('Email') }}</th>
                                <th scope="col">{{ __('Image') }}</th>
                                <th scope="col">{{ __('Role') }}</th>
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
                    ajax: "{{route('backend.user.list')}}",
                    columns: [
                        { data: 'id' },
                        { data: 'name' },
                        { data: 'email' },
                        { data: 'avatar',searchable:false,sortable:false },
                        { data: 'role',searchable:false,sortable:false },
                        { data: 'is_active' },
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
                    url: public_path +'/admin/user/changeStatus',
                    data: {'status': status, 'id': id,'field': 'is_active'},
                    success: function(data){
                        notification('success', data.message);
                    }
                });
            });
        });
    </script>
@endpush
