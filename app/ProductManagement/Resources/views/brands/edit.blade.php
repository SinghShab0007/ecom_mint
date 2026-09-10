@extends('backend.layouts.app')
@section('title','Brands - ')
@section('content')
    <div class="content-body">
    @include('productmanagement::includes.product_management')
        <!-- Tab Content Start -->
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="add-brand" role="tabpanel" aria-labelledby="add-brand-tab">
                <div class="container">
                    <form class="add-brand-form" id="brandsForm" action="@auth('admin'){{route('backend.brands.update',$brand->id)}}@elseauth('seller'){{route('seller.brands.update',$brand->id)}}@endauth" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('productmanagement::brands.form')
                        <div class="col-lg-7 offset-lg-3">
                            <div class="from-submit-btn">
                                <button class="submit-btn" type="submit">{{__('Update')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Tab Content End -->
    </div>

@endsection
