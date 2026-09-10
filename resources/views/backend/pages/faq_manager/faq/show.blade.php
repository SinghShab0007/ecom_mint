@extends('backend.layouts.app')
@section('title','FAQ Show - ')
@section('content')
    <div class="content-body">
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="create-faq" role="tabpanel" aria-labelledby="create-faq-tab">
                <div class="container content-title">
                    <h4>{{__('FAQ Information')}}</h4>
                </div>
                <div class="container">
                    <div class="row">
                        <form class="add-brand-form">
                            <div class="row">
                                <div class="col-lg-3">
                                    <p>{{__('Category')}}</p>
                                </div>
                                <div class="col-lg-7">
                                    {{$faq->category->name??''}}
                                </div>
                                <div class="col-lg-3">
                                    <p>{{__('Sub-Category')}}</p>
                                </div>
                                <div class="col-lg-7">
                                    {{$faq->sub_category->name??''}}
                                </div>
                                <div class="col-lg-3">
                                    <p>{{__('Question')}}</p>
                                </div>
                                <div class="col-lg-7">
                                    {{$faq->question??''}}
                                </div>
                                <div class="col-lg-3">
                                    <p>{{__('Answer')}}</p>
                                </div>
                                <div class="col-lg-7">
                                    {{$faq->answer??''}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tab Content End -->
    </div>

@endsection
