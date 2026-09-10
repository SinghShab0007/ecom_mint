@extends('backend.layouts.app')
@section('title','Product - ')
@push('css')
    @include('backend.includes.datatable_css')
@endpush
@section('content')
    <div class="content-body">

    <!-- Tab Content Start -->
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="all-product" aria-labelledby="all-product-tab">
                <div class="container">

                    <div class="content-table">
                        <div class="content-tab-title">
                            <h4>{{__('Product Management')}}</h4>
                        </div>
                        <form action="{{route('backend.products.wholesale.store')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-5">
                                    <label>{{__('Select Product')}}</label>
                                    <select class="form-control form-select" name="product_id" required>
                                        <option value="" selected>{{__('Select a Product')}}</option>
                                        @foreach($products as  $product)
                                        <option value="{{$product->id}}">{{$product->name}} {{'( $ '}} {{$product->sale_price}} {{')'}}</option>
                                        @endforeach
                                    </select>
                                    <div id="add-btn" class="add-more-btn-admin">{{__('Add More')}}</div>
                                </div>
                                <div class="col-lg-7" id="product-price-input-list">
                                    <div class="row add-input-group-items" >
                                        <div class="col-4">
                                            <label >{{__('Minimum Qty')}}</label>
                                            <input type="number" name="min_range[]" class="form-control" placeholder="Minimum Qty">
                                        </div>
                                        <div class="col-4">
                                            <label >{{__('Maximum Qty')}}</label>
                                            <input type="number"  name="max_range[]" class="form-control" placeholder="maximum Qty">
                                        </div>
                                        <div class="col-4">
                                            <label >{{__('Price')}}</label>
                                            <input type="number" name="price[]" class="form-control" placeholder="Price">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 text-end">
                                    <button class="btn add-more-btn-admin" type="submit">{{__('Save')}}</button>
                                </div>
                            </div>
                        </form>
                        <!-- try -->

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
            $( document ).ready(()=>{
                $( "#add-btn" ).on( "click",()=>{
                    $("#product-price-input-list").append(`
                        <div class="row add-input-group-items align-items-center" >
                            <div class="col-3 mt-3">
                                <input type="number" name="min_range[]" class="form-control" placeholder="Minimum Qty">
                            </div>
                            <div class="col-3 mt-3">
                                <input type="number" name="max_range[]" class="form-control" placeholder="maximum Qty">
                            </div>
                            <div class="col-3 mt-3">
                                <input type="number" name="price[]" class="form-control" placeholder="Price">
                            </div>
                            <div class="col-3 mt-3">
                                <div class="remove-input-list"><i class="fa-solid fa-trash"></i></div>
                            </div>
                        </div>
                    `);
                });

                $("body").on("click", ".remove-input-list", function () {
                    $(this).closest(".add-input-group-items").remove();
                });



            })

            $(".form-select").select2();
        });
    </script>
@endpush
