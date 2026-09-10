@extends('layouts.seller')

@section('title','Brands - ')

@section('content')
    <div class="content-body">
        @include('seller.product._header')
        
        <div class="container">
            <form action="{{ route('seller.brands') }}">
                <div class="col-4 offset-4">
                    <div class="input-group py-3 mb-0">
                        <input type="text" name="q" class="form-control" placeholder="Search Brand" aria-label="Example text with button addon" aria-describedby="button-addon2">
                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">
                            <i class="fa-brands fa-searchengin"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="brand" role="tabpanel" aria-labelledby="brand-tab">
                <div class="container">
                    <div class="content-table mt-0">
                        <table id="mDataTable" class="table p-table">
                            <thead>
                            <tr>
                                <th scope="col">{{ __('ID') }}</th>
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('Slug') }}</th>
                                <th scope="col">{{ __('Logo') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($brands as $brand)
                                <tr>
                                    <td>{{ $brand->id }}</td>
                                    <td>{{ $brand->name }}</td>
                                    <td>{{ $brand->slug }}</td>
                                    <td>
                                        <img src="{{ asset('uploads/brands/120x80/') }}/{{ $brand->image }}" width="60px" height="60px" alt="brand">
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <x-seller.page-navigation :paginator="$brands"></x-seller.page-navigation>
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
                var brand_id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: public_path +@auth('admin')'/admin/brand/changeStatus'@elseauth('seller')'/seller/brand/changeStatus'@endauth,
                    data: {'status': status, 'brand_id': brand_id,'field': 'is_active'},
                    success: function(data){
                        notification('success', data.message);
                    }
                });
            });
        });
    </script>
@endpush
