@extends('backend.layouts.app')
@section('title','Roles - ')
@push('css')
    @include('backend.includes.datatable_css')
@endpush
@section('content')
    <div class="content-body">
    @include('backend.pages.user_permission.nav')
    <!-- Tab Content Start -->
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="roles" aria-labelledby="roles-tab">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <a href="{{route('backend.roles.create')}}" methods="get" class="float-end">
                                <button class="btn theme-btn">{{ __('Add Role') }}</button>
                            </a>
                        </div>
                    </div>
                    <div class="content-table">
                        <table id="mDataTable" class="table p-table">
                            <thead>
                            <tr>
                                <th scope="col">{{ __('Id') }}</th>
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('Guard Name') }}</th>
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
                    ajax: "{{route('backend.role.list')}}",
                    columns: [
                        { data: 'id' },
                        { data: 'name' },
                        { data: 'guard_name' },
                        { data: 'action',searchable:false,sortable:false },
                    ]
                });
            });
        });
    </script>
@endpush
