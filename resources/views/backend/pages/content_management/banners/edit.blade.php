@extends('backend.layouts.app')
@section('title','Banner - ')
@section('content')
    <div class="content-body">
        <!-- Tab Content Start -->
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="add-category" role="tabpanel" aria-labelledby="add-category-tab">
                <div class="container content-title">
                    <h4>{{__('Banner Information')}}</h4>
                </div>
                <div class="container">
                    <form id="bannerForm" method="post" action="@auth('admin'){{route('backend.banners.update',$banner->id)}}@elseauth('seller'){{route('seller.banners.update',$banner->id)}}@endauth" enctype="multipart/form-data" class="add-brand-form">
                        @csrf()
                        @method('PUT')
                        @include('backend.pages.content_management.banners.form')
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
