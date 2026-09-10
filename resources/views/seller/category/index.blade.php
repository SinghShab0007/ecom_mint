@extends('layouts.seller')

@section('title','Category - ')

@section('content')
    <div class="content-body">
        @include('seller.product._header')
        <!-- Tab Content Start -->
        <div class="container">
            <form action="{{ route('seller.categories') }}">
                <div class="col-4 offset-4">
                    <div class="input-group py-3 mb-0">
                        <input type="text" name="q" class="form-control" placeholder="Search Category" aria-label="Example text with button addon" aria-describedby="button-addon2">
                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">
                            <i class="fa-brands fa-searchengin"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="category" role="tabpanel" aria-labelledby="category-tab">
                <div class="container">
                    <div class="content-table mt-0">
                        <table id="mDataTable" class="table p-table">
                            <thead>
                            <tr>
                                <th scope="col">{{ __('Id') }}</th>
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('Image') }}</th>
                                <th scope="col">{{ __('Parent') }}</th>
{{--                                <th scope="col">{{ __('Display') }}</th>--}}
{{--                                <th scope="col">{{ __('Sort') }}</th>--}}
{{--                                <th scope="col">{{ __('Status') }}</th>--}}
                                <th scope="col">{{ __('Commission') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <img src="{{ asset('uploads/categories/32x32/') }}/{{ $category->icon }}" width="60px" height="60px" alt="logo">
                                </td>
                                <td>{{ $category->parents->name ?? 'ROOT' }}</td>
{{--                                <td>--}}
{{--                                    <div class="form-switch">--}}
{{--                                        <input class="form-check-input display_out_website" type="checkbox" data-id="{{ $category->id }}" {{ $category->show_in_home == 1 ? 'checked' : '' }}>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                                <td>{{ $category->order }}</td>--}}
{{--                                <td>--}}
{{--                                    <div class="form-switch">--}}
{{--                                        <input class="form-check-input status" type="checkbox" data-id="{{ $category->id }}" {{ $category->is_active == 1 ? 'checked' : '' }}>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
                                <td>{{ $category->commission_rate }}%</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <x-seller.page-navigation :paginator="$categories"></x-seller.page-navigation>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tab Content End -->
    </div>
@endsection

@push('js')
    <script>
        $(function() {
            "use strict";
            $(document).on('click','#mDataTable .status', function() {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var cat_id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: public_path +'/seller/category/changeStatus',
                    data: {'status': status, 'cat_id': cat_id,'field': 'is_active'},
                    success: function(data){
                        notification('success', data.message);
                    }
                });
            });
            $(document).on('click','#mDataTable .display_out_website', function() {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var cat_id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: public_path +'/seller/category/changeStatus',
                    data: {'status': status, 'cat_id': cat_id,'field': 'show_in_home'},
                    success: function(data){
                        notification('success', data.message);
                    }
                });
            });

            {{--$(document).ready(function(){--}}
            {{--    // DataTable--}}
            {{--    var table = $('#mDataTable');--}}
            {{--    table.DataTable({--}}
            {{--        ajax: "@auth('admin'){{route('backend.category.list')}}@elseauth('seller'){{route('seller.category.list')}}@endauth",--}}
            {{--        columns: [--}}
            {{--            { data: 'id' },--}}
            {{--            { data: 'name' },--}}
            {{--            { data: 'image',searchable:false,sortable:false },--}}
            {{--            { data: 'category_id' },--}}
            {{--            { data: 'show_in_home' },--}}
            {{--            { data: 'order' },--}}
            {{--            { data: 'is_active' },--}}
            {{--            { data: 'action',searchable:false,sortable:false },--}}
            {{--        ]--}}
            {{--    });--}}
            {{--});--}}
        });
    </script>
@endpush
