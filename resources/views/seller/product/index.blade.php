@extends('layouts.seller')

@section('title','Products')

@section('content')

    <div class="content-body">
        @include('seller.product._header')
        <!-- Tab Content Start -->
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="all-product" aria-labelledby="all-product-tab">
                <div class="container">

                    <div class="content-table mt-0">

                        <table id="mDataTable" class="table p-table">
                            <thead>
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Image') }}</th>
                                <th>{{ __('SKU') }}</th>
                                <th>{{ __('Price') }}</th>
                                <th>{{ __('Stock') }}</th>
                                <th>{{ __('Sold') }}</th>
                                <th>{{ __('Viewed') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td><img src="{{ asset('uploads/products/galleries/') }}/{{ optional($product->images)->first()->image ?? '' }}" width="60" height="60" alt=""></td>
                                    <td>{{ $product->sku }}</td>
                                    <td>{{ $product->sale_price }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>{{ $product->sold }}</td>
                                    <td>{{ $product->total_viewed }}</td>
                                    <td>
                                        <div class="form-switch">
                                            <input class="form-check-input status" type="checkbox" data-id="{{ $product->id }}" {{ $product->is_active == 1 ? 'checked' : '' }}></div>
                                    </td>
                                    <td>
                                        <form user="deleteForm" method="POST" action="{{ route('seller.product.destroy',$product->id) }}">
                                            @csrf
                                            @method('delete')
                                            <a class="btn text-warning btn-sm action border-warning" href="{{ route('seller.product.edit',$product->id) }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a class="p-0 action" href="javascript:void(0);"
                                               onclick="deleteWithSweetAlert(event,parentNode);">
                                                <button class="btn text-danger btn-sm" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </a>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if($products->hasPages())
                            <nav class="new-pagination mt-3">
                                <ul class="pagination">
                                    @if($products->onFirstPage())
                                        <li class="page-item active"><a class="page-link">Previous</a></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $products->previousPageUrl() }}">{{ __('Previous') }}</a></li>
                                    @endif
                                    @foreach($products->getUrlRange(1,$products->lastPage()) as $key => $url)
                                        @if($products->currentPage() == $key)
                                            <li class="page-item active"><a class="page-link">{{ $key }}</a></li>
                                        @else
                                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $key }}</a></li>
                                        @endif
                                    @endforeach
                                    @if($products->hasMorePages())
                                        <li class="page-item"><a class="page-link" href="{{ $products->nextPageUrl() }}">{{ __('Next') }}</a></li>
                                    @else
                                        <li class="page-item active"><a class="page-link">Next</a></li>
                                    @endif
                                </ul>
                            </nav>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- Tab Content End -->
    </div>

@stop
