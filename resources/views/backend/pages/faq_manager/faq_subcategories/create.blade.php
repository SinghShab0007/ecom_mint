@extends('backend.layouts.app')
@section('title','Category - ')
@section('content')
    <div class="content-body">
        <div class="container">
        @include('backend.pages.faq_manager.nav')
            <!-- Tab Manu End -->
        </div>
        <!-- Tab Content Start -->
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="add-category" role="tabpanel" aria-labelledby="add-category-tab">
                <div class="container content-title">
                    <h4>{{__('FAQ SubCategory Information')}}</h4>
                </div>
                <div class="container">
                    <form id="faqForm" method="post" action="{{route('backend.faq_subcategory.store')}}" enctype="multipart/form-data" class="add-brand-form">
                        @csrf()
                        @include('backend.pages.faq_manager.faq_subcategories.form')
                        <div class="col-lg-7 offset-3">
                            <div class="from-submit-btn">
                                <button class="submit-btn" type="submit">{{__('Save')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Tab Content End -->
    </div>
@endsection
