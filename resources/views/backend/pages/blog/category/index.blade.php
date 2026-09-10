@extends('backend.layouts.app')
@section('title','Website Pages - ')
@push('css')
    @include('backend.includes.datatable_css')
@endpush
@section('content')
    <div class="content-body">
        <div class="container">
            <div class="main-content default-manu">
            @include('backend.pages.blog.nav')
            <!-- Tab Manu End  -->
                <!-- Tab Content Start -->
                <div class="tab-content default-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="blog-category" aria-labelledby="blog-category-tab">
                        <div class="row">
                            <div class="col">
                                <div class="float-md-end">
                                    <a href="{{route('backend.blog.category.create')}}">
                                        <button class="btn btn-warning pull-right"> {{ __('Add Category') }}</button>
                                    </a>

                                </div>
                            </div>
                        </div>
                        <div class="content-table">
                            <table id="mDataTable" class="table p-table">
                                <thead>
                                <tr>
                                    <th scope="col">{{ __('Id') }}</th>
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col">{{ __('Slug') }}</th>
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
        $(function() {

            "use strict";

            $(document).ready(function(){
                // DataTable
                var table = $('#mDataTable');
                table.DataTable({
                    ajax: "{{route('backend.blog.category.list')}}",
                    columns: [
                        { data: 'id' },
                        { data: 'name' },
                        { data: 'slug' },
                        { data: 'action',searchable:false,sortable:false },
                    ]
                });

            });
        });
    </script>
@endpush
