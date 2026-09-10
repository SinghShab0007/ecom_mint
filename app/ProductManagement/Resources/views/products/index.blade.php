@extends('backend.layouts.app')
@section('title','Product - ')
@push('css')
    @include('backend.includes.datatable_css')
@endpush
@section('content')
    <div class="content-body">
        @include('productmanagement::includes.product_management')
        <!-- Tab Content Start -->
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="all-product" aria-labelledby="all-product-tab">
                <div class="container">

                    <div class="content-table mt-0">

                        <table id="mDataTable" class="table p-table">
                            <thead>
                            <tr>
                                <th scope="col">{{__('ID')}}</th>
                                <th scope="col">{{__('Name')}}</th>
                                <th scope="col">{{__('Image')}}</th>
                                <th scope="col">{{__('SKU')}}</th>
                                <th scope="col">{{__('Price')}}</th>
                                <th scope="col">{{__('Stock')}}</th>
                                <th scope="col">{{__('Sold')}}</th>
                                <th scope="col">{{__('Viewed')}}</th>
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

    <div class="modal fade" id="product-view-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Product Views</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="product-view-modal-content-wrapper">
                        <div class="product-thumb text-center">
                            <img src="https://moova.maantechnology.com/back-end/img/gallery_image/16582944927366.jpg" alt="product-thumb">
                        </div>
                        <div class="row prodcut-info-items">
                            <div class="col-md-12">
                                <h5>Product Information</h5>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Product Name:</strong> Lorem ipsum dolor, sit amet</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Minimum Qty:</strong> 10</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Category:</strong> Baby</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Tags:</strong> Baby, Maan, Woman</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Brand:</strong> Fashion</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Slug:</strong> baby</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Sku:</strong> MS0044</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Seller:</strong> Kobir Mia </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Warranty:</strong> 6 Month </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Return Policy:</strong> 7 Days </p>
                            </div>
                        </div>
                        <div class="row prodcut-info-items">
                            <div class="col-md-12">
                                <h5>Product Variation</h5>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Color:</strong> red</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Sizes:</strong> M, SM</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Attributes:</strong> Baby</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Tags:</strong> Baby, Maan, Woman</p>
                            </div>
                        </div>
                        <div class="row prodcut-info-items">
                            <div class="col-md-12">
                                <h5>Product price + stock</h5>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Unit Price:</strong> 1200</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Purchase Price:</strong> 800</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Discount:</strong> 50</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Quantity:</strong> 100</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Shipping Cost:</strong> 50</p>
                            </div>
                        </div>
                        <div class="row prodcut-info-items">
                            <div class="col-md-12">
                                <h5>Discription</h5>
                            </div>
                            <div class="col-md-12">
                                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aperiam quibusdam nam molestias, voluptas suscipit magnam impedit iusto autem possimus? Aspernatur!</p>
                            </div>
                        </div>
                    </div>
                </div>
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
                    ajax: "@auth('admin'){{route('backend.product.list')}}@elseauth('seller'){{route('seller.product.list')}}@endauth",
                    columns: [
                        { data: 'id' },
                        { data: 'name' },
                        { data: 'image',searchable:false,sortable:false },
                        { data: 'sku' },
                        { data: 'unit_price' },
                        { data: 'quantity' },
                        { data: 'sold',searchable:false,sortable:false},
                        { data: 'total_viewed' },
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
                    url: public_path +@auth('admin')'/admin/product/changeStatus'@elseauth('seller')'/seller/product/changeStatus'@endauth,
                    data: {'status': status, 'id': id,'field': 'is_active'},
                    success: function(data){
                        notification('success', data.message);
                    }
                });
            });
        });
    </script>
@endpush
