@extends('backend.layouts.app')
@section('title', 'Stock List')

@section('content')
    <div class="content-body">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2">{{ __('Product details') }} <a class="btn btn-primary btn-sm rounded-pill text-light" href="{{ route('backend.stocks.index') }}"><i class="fa fa-backward" aria-hidden="true"></i> {{ __('Back') }}</a></h6>

                    <table class="table p-0 p-table table-bordered table-striped table-hover text-center">
                        <thead class="bg-secondary text-light text-center">
                            <tr>
                                <th>{{__('ID')}}</th>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Price')}}</th>
                                <th>{{__('Stock')}}</th>
                                <th>{{__('Sold')}}</th>
                                <th>{{__('Viewed')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="borderd">
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ currency($product->unit_price, 2) }}</td>
                                <td>
                                    <div class="badge bg-success">
                                        {{ $product->quantity }}
                                    </div>
                                </td>
                                <td>{{ $product->orders_sum_qty }}</td>
                                <td>{{ $product->total_viewed }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <h5 class="my-2 mt-3">{{ __('Product Variations') }}</h5>
                    <table class="table p-0 p-table table-bordered table-striped table-hover text-center">
                        <thead class="bg-secondary text-light text-center">
                            <tr>
                                <th>{{__('#')}}</th>
                                <th>{{__('Color')}}</th>
                                <th>{{__('Size')}}</th>
                                <th>{{__('Stock')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product->productstock as $stock)
                            <tr class="borderd">
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $stock->color->name ?? '' }}</td>
                                <td>{{ $stock->size->name ?? '' }}</td>
                                <td>
                                    <div class="badge bg-primary">
                                        {{ $stock->quantities }}
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
