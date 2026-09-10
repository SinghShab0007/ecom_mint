@extends('backend.layouts.app')
@section('title', 'Stock List')

@section('content')
    <div class="content-body">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h5>{{ __('Manage Stock') }}</h5>
                    <table class="table p-0 p-table table-bordered table-striped table-hover">
                        <thead class="bg-secondary text-light">
                            <tr>
                                <th>{{__('ID')}}</th>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Price')}}</th>
                                <th>{{__('Stock')}}</th>
                                <th>{{__('Sold')}}</th>
                                <th>{{__('Viewed')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
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
                                <td>
                                    <a href="{{ route('backend.stocks.show', $product->id) }}" class="text-warning">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row float-end pt-3">
                        <div class="col-12 text-center">
                            {{ $products->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
