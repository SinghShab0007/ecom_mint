@extends('backend.layouts.app')
@section('title','Sellers - ')
@section('content')
    <div class="content-body">
    @include('sellermanagement::includes.tab_menu')
        <!-- Tab Content Start -->
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="create-seller" role="tabpanel" aria-labelledby="create-seller-tab">
                <div class="container content-title">
                    <h4>{{__('Seller Information')}}</h4>
                </div>
                <div class="container">
                    <form id="sellerForm" class="add-brand-form" action="{{route('backend.sellers.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @include('sellermanagement::sellers.form')
                    </form>
                </div>
            </div>
        </div>
        <!-- Tab Content End -->
    </div>
@endsection
