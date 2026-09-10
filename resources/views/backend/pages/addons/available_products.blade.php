@extends('backend.layouts.app')
@section('title','Available Products - ')
@push('css')

@endpush
@section('content')
    <div class="content-body">
        <div class="container">
            @include('backend.pages.addons.nav')
        </div>
        <!-- Tab Content Start -->
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="available-product" aria-labelledby="available-product-tab">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="s-category">

                            </div>
                        </div>
                        <div class="col-lg-3 offset-lg-6">
                        </div>
                    </div>
                    <div class="row adon-cards">
                        @foreach($addons as $key => $addon)
                            @if(!$addon->is_install)
                                <div class="col-lg-6 col-xl-12">
                                    <div class="row adon-card">
                                        <div class="col-xl-4">
                                            <div class="adon-img">
                                                <img src="{{URL::to('uploads/addons/'.$addon->image_300x300)}}" alt="addon-card">
                                            </div>
                                        </div>
                                        <div class="col-xl-8">
                                            <div class="adon-content">
                                                <h6>{{$addon->addon_title??''}}</h6>
                                                <span class="price">${{$addon->purchase_price-$addon->discount}}</span>
                                                <p>{{$addon->description??''}}</p>
                                                <div class="links-btn">
                                                    <ul>
                                                        <li><a target="_blank" href="{{$addon->addon_preview}}">{{__('Preview')}}</a></li>
                                                        <li><a target="_blank" href="{{$addon->purchase_link}}">{{__('Purchase')}}</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- Tab Content End -->
    </div>


@endsection

@push('js')

@endpush
