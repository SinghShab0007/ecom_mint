@extends('backend.layouts.app')
@section('title','Product Review - ')
@section('content')
    <div class="content-body">
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="create-product_review" role="tabpanel"
                 aria-labelledby="create-product_review-tab">
                <div class="container content-title">
                    <h4>{{__('Product Review')}}</h4>
                </div>
                <div class="container">
                    <div class="row">
                        <form class="add-brand-form">
                            <div class="row">
                                <div class="col-lg-3">
                                    <p>{{__('Product Name')}}</p>
                                </div>
                                <div class="col-lg-7">
                                    {{$product_review->product->name??''}}
                                </div>
                                <div class="col-lg-3">
                                    <p>{{__('Customer')}}</p>
                                </div>
                                <div class="col-lg-7">
                                    {{$product_review->customer?$product_review->customer->full_name():''}}
                                </div>
                                <div class="col-lg-3">
                                    <p>{{__('Point')}}</p>
                                </div>
                                <div class="col-lg-7">
                                    {{$product_review->review_point??''}}
                                </div>
                                <div class="col-lg-3">
                                    <p>{{__('Comment')}}</p>
                                </div>
                                <div class="col-lg-7">
                                    {{$product_review->review_note??''}}
                                </div>
                                <div class="col-lg-3">
                                    <p>{{__('Status')}}</p>
                                </div>
                                <div class="col-lg-7">
                                    <div class="form-switch">
                                        <input class="form-check-input status" type="checkbox"
                                               data-id="{{$product_review->id}}"
                                               @if($product_review->is_active)checked @endif>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <p>{{__('Publish')}}</p>
                                </div>
                                <div class="col-lg-7">
                                    <div class="form-switch">
                                        <input class="form-check-input publish" type="checkbox"
                                               data-id="{{$product_review->id}}"
                                               @if($product_review->publish_stat)checked @endif>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tab Content End -->
    </div>

@endsection
@push('js')
    <script>
        $(function () {

            "use strict";
            $(document).on('click', '.status', function () {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: public_path + @auth('admin')'/admin/product_review/changeStatus'@elseauth('seller')'/seller/product_review/changeStatus'@endauth,
                    data: {'status': status, 'id': id, 'field': 'is_active'},
                    success: function (data) {
                        notification('success', data.message);
                    }
                });
            });
            $(document).on('click', '.publish', function () {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: public_path + @auth('admin')'/admin/product_review/changeStatus'@elseauth('seller')'/seller/product_review/changeStatus'@endauth,
                    data: {'status': status, 'id': id, 'field': 'publish_stat'},
                    success: function (data) {
                        notification('success', data.message);
                    }
                });
            });
        });
    </script>
@endpush
