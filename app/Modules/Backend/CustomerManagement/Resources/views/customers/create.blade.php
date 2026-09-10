@extends('backend.layouts.app')
@section('title','Customer - ')
@section('content')
    <div class="content-body">
    @include('customermanagement::nav')
    <!-- Tab Content Start -->
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="create-customers" aria-labelledby="create-customers-tab">
                <div class="container content-title">
                    <h4>{{__('Customer Information')}}</h4>
                </div>
                <div class="container">
                    <form id="customersForm" class="add-brand-form" action="{{route('backend.customers.store')}}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @include('customermanagement::customers.form')
                        <div class="col-lg-7 offset-3">
                            <div class="from-submit-btn">
                                <button class="submit-btn" type="submit">{{__('Save')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


