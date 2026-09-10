@extends('backend.layouts.app')
@section('title','Announcements - ')
@push('css')

@endpush
@section('content')
    <div class="content-body">
        <div class="container">
            <div class="main-content default-manu">
            @include('backend.pages.website_setting.nav')
            <!-- Tab Content Start -->
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="add-category" role="tabpanel"
                         aria-labelledby="add-category-tab">
                        <div class="container content-title">
                            <h4>{{__('Announcements Information')}}</h4>
                        </div>
                        <div class="container">
                            <form id="announcementsForm" method="post"
                                  action="{{route('backend.announcements.update',$announcements->id)}}"
                                  enctype="multipart/form-data" class="add-brand-form">
                                @csrf()
                                @method('PUT')
                                @include('backend.pages.website_setting.announcements.form')
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
        </div>
    </div>

@endsection
@push('js')

@endpush
