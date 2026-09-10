@extends('backend.layouts.app')
@section('title','FAQ Category - ')
@section('content')
    <div class="content-body">
        <!-- Tab Content Start -->
        <div class="container">
        @include('backend.pages.faq_manager.nav')
            <!-- Tab Manu End -->
        </div>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="add-category" role="tabpanel" aria-labelledby="add-category-tab">
                <div class="container content-title">
                    <h4>{{__('FAQ Information')}}</h4>
                </div>
                <div class="container">
                    <form id="faqForm" method="post" action="{{route('backend.faq_category.update',$faq_category->id)}}" enctype="multipart/form-data" class="add-brand-form">
                        @csrf()
                        @method('PUT')
                        @include('backend.pages.faq_manager.faq_categories.form')
                        <div class="col-lg-7 offset-3">
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
