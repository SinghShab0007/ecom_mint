@extends('backend.layouts.app')
@section('title','Website Header - ')
@push('css')
@endpush
@section('content')
    <div class="content-body">
        <div class="container">
            <div class="main-content default-manu">
            @include('backend.pages.website_setting.nav')
            <!-- Tab Manu End  -->
                <!-- Tab Content Start -->
                <div class="tab-content default-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="header" aria-labelledby="header-tab">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="check-toggle-btn input-group">
                                    <label for="show-lang-btn">{{__('Show Language Switcher?')}}</label>
                                    <div class="form-switch">
                                        <input class="form-check-input show_language" @if($header->show_language)checked
                                               @endif type="checkbox">
                                    </div>
                                </div>
                                <div class="check-toggle-btn input-group">
                                    <label for="show-cur-btn">{{__('Show Currency Switcher?')}}</label>
                                    <div class="form-switch">
                                        <input class="form-check-input show_currency" @if($header->show_currency)checked
                                               @endif type="checkbox">
                                    </div>
                                </div>
                                <div class="check-toggle-btn">
                                    <label for="stikcy-head-btn">{{__('Enable Sticky Header?')}}</label>
                                    <div class="form-switch">
                                        <input class="form-check-input enable_stikcy_header"
                                               @if($header->enable_sticky_header)checked @endif type="checkbox">
                                    </div>

                                </div>
                                <div class="check-toggle-btn">
                                    <label for="tracking-o-btn">{{__('Tracking Order')}}</label>
                                    <div class="form-switch">
                                        <input class="form-check-input enable_tracking_order"
                                               @if($header->enable_tracking_order)checked @endif type="checkbox">
                                    </div>

                                </div>
                                <div class="check-toggle-btn">
                                    <label for="help-btn">{{__('Help')}}</label>
                                    <div class="form-switch">
                                        <input class="form-check-input show_help" @if($header->show_help)checked
                                               @endif type="checkbox">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tab Content End  -->
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(function () {

            "use strict";
            $(document).on('click', '#header .show_language', function () {
                var status = $(this).prop('checked') == true ? 1 : 0;

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: public_path + '/admin/website_setting/changeStatus',
                    data: {'status': status, 'field': 'show_language'},
                    success: function (data) {
                        notification('success', data.message);
                    }
                });
            });
            $(document).on('click', '#header .show_currency', function () {
                var status = $(this).prop('checked') == true ? 1 : 0;

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: public_path + '/admin/website_setting/changeStatus',
                    data: {'status': status, 'field': 'show_currency'},
                    success: function (data) {
                        notification('success', data.message);
                    }
                });
            });
            $(document).on('click', '#header .enable_stikcy_header', function () {
                var status = $(this).prop('checked') == true ? 1 : 0;

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: public_path + '/admin/website_setting/changeStatus',
                    data: {'status': status, 'field': 'enable_sticky_header'},
                    success: function (data) {
                        notification('success', data.message);
                    }
                });
            });
            $(document).on('click', '#header .enable_tracking_order', function () {
                var status = $(this).prop('checked') == true ? 1 : 0;

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: public_path + '/admin/website_setting/changeStatus',
                    data: {'status': status, 'field': 'enable_tracking_order'},
                    success: function (data) {
                        notification('success', data.message);
                    }
                });
            });
            $(document).on('click', '#header .show_help', function () {
                var status = $(this).prop('checked') == true ? 1 : 0;

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: public_path + '/admin/website_setting/changeStatus',
                    data: {'status': status, 'field': 'show_help'},
                    success: function (data) {
                        notification('success', data.message);
                    }
                });
            });

        });
    </script>
@endpush
