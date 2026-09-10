@extends('backend.layouts.app')

@section('title','Questions & Answer - ')

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
            <div class="tab-pane fade show active" id="questions-and-answer" role="tabpanel"
                 aria-labelledby="questions-and-answer-tab">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-8 mb-2">
                            <div class="title">
                                <h4>{{__('Frequently Asked Questions')}}</h4>
                                <p>{{__('The Beginning of a new asset class')}} </p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="float-md-end">
                                <a href="{{route('backend.faq_content.create')}}">
                                    <button class="btn theme-btn"> {{ __('Add FAQ') }}</button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="content-table">
                        <table id="mDataTable" class="table p-table">
                            <thead>
                            <tr>
                                <th scope="col">{{ __('Id') }}</th>
                                <th scope="col">{{ __('Category') }}</th>
                                <th scope="col">{{ __('SubCategory') }}</th>
                                <th scope="col">{{ __('Question') }}</th>
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
                    ajax: "{{route('backend.faq_content.list')}}",
                    columns: [
                        { data: 'id'},
                        { data: 'category_name' },
                        { data: 'subcategory_name'},
                        { data: 'question' },
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
                    url: public_path +'/admin/faq_contents/changeStatus',
                    data: {'status': status, 'id': id,'field': 'is_active'},
                    success: function(data){
                        notification('success', data.message);
                    }
                });
            });
        });
    </script>
@endpush
