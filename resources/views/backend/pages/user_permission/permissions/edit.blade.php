@extends('backend.layouts.app')
@section('title','Permissions - ')
@section('content')
    <div class="content-body">
        @include('backend.pages.user_permission.nav')
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="add-category" role="tabpanel" aria-labelledby="add-category-tab">
                <div class="container content-title">
                    <h4>{{__('Permissions Information')}}</h4>
                </div>
                <div class="container">
                    <form id="permissionsForm" class="add-brand-form" action="{{route('backend.permissions.update',$permission->id)}}" method="post">
                        @csrf
                        @method('PUT')
                        @include('backend.pages.user_permission.permissions.form')
                        <div class="col-lg-7 offset-3">
                            <div class="from-submit-btn">
                                <button class="submit-btn" type="submit">{{__('Update')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
