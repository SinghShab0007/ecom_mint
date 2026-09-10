@extends('backend.layouts.app')
@section('title','FAQ Category - ')
@push('css')
    @include('backend.includes.datatable_css')
@endpush
@section('content')
    <div class="content-body">
        <div class="container">
        @include('backend.pages.faq_manager.nav')
        <!-- Tab Manu End -->
        </div>
        <!-- Tab Content Start -->
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="faq-category" role="tabpanel" aria-labelledby="faq-category-tab">
                <div class="container">
                    <div class="row mb-4">
                        <div class="col">
                            <div class="float-md-end">
                                <a href="{{route('backend.faq_category.create')}}">
                                    <button class="btn theme-btn"> {{ __('Add FAQ Category') }}</button>
                                </a>

                            </div>
                        </div>
                    </div>
                    <div class="content-table mt-0">
                        <table id="mDataTable" class="table p-table">
                            <thead>
                            <tr>
                                <th scope="col">{{__('Name')}}</th>
                                <th scope="col">{{__('Icon')}}</th>
                                <th scope="col">{{__('Order')}}</th>
                                <th scope="col">{{__('Slug')}}</th>
                                <th scope="col">{{__('Status')}}</th>
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
        $(function () {

            "use strict";
            $(document).ready(function(){
                // DataTable
                var table = $('#mDataTable');
                table.DataTable({
                    ajax: "{{route('backend.faq_category.list')}}",
                    columns: [
                        { data: 'name' },
                        { data: 'icon'},
                        { data: 'order' },
                        { data: 'slug' },
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
                    url: public_path +'/admin/faq_category/changeStatus',
                    data: {'status': status, 'id': id,'field': 'is_active'},
                    success: function(data){
                        notification('success', data.message);
                    }
                });
            });

        });
    </script>
@endpush
