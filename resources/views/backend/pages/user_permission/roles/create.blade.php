@extends('backend.layouts.app')
@section('title','Roles - ')
@section('content')
    <div class="content-body">
        @include('backend.pages.user_permission.nav')
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="add-category" role="tabpanel" aria-labelledby="add-category-tab">
                <div class="container content-title">
                    <h4>{{__('Role Information')}}</h4>
                </div>
                <div class="container">
                    <form id="rolesForm" method="post" action="{{route('backend.roles.store')}}" enctype="multipart/form-data" class="add-brand-form">
                        @csrf()
                        @include('backend.pages.user_permission.roles.form')
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
