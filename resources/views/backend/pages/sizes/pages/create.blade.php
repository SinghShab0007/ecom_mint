@extends('backend.layouts.app')
@section('title','Pages - ')
@push('css')

@endpush
@section('content')
    <div class="content-body">
        <div class="container">
            <div class="main-content default-manu">
                @include('backend.pages.sizes.nav')
                <!-- Tab Manu End  -->
                <!-- Tab Content Start -->
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="add-category" role="tabpanel" aria-labelledby="add-category-tab">
                <div class="container content-title">
                    <h4>{{__('Add Size')}}</h4>
                </div>
                    <form id="pageForm" method="post" action="{{route('backend.sizes.store')}}" enctype="multipart/form-data" class="add-brand-form">
                        @csrf()
                        @include('backend.pages.sizes.pages.form')
                        <div class="col-lg-7 offset-3">
                            <div class="from-submit-btn">
                                <button class="submit-btn" type="submit">{{__('Save')}}</button>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
        <!-- Tab Content End -->
    </div>
    </div>
    </div>

@endsection
@push('js')

@endpush
