@extends('backend.layouts.app')
@section('title','Brands - ')
@section('content')
    <div class="content-body">
    @include('productmanagement::includes.product_management')
        <!-- Tab Content Start -->
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="add-brand" role="tabpanel" aria-labelledby="add-brand-tab">
                <div class="container">
                    <form class="add-brand-form" id="brandForm" action="@auth('admin'){{route('backend.brands.store')}}@elseauth('seller'){{route('seller.brands.store')}}@endauth" method="post" enctype="multipart/form-data">
                        @csrf()
                        @include('productmanagement::brands.form')

                        <div class="col-lg-7 offset-lg-3">
                            <div class="from-submit-btn">
                                <button class="submit-btn" type="submit">{{('Save')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Tab Content End -->
    </div>
@endsection
