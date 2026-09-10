@extends('frontend.layouts.front')

@section('title','Seller Profile')

@section('content')
    <div class="multivendor-shop-bg">
        <div class="container">
            <div class="img-wrapper">
                <img src="{{ asset('uploads/sellers/'.$seller->banner) }}" alt="">
            </div>
        </div>
    </div>

    <section class="multivendor-profile-section">
        <div class="container">
            <div class="multivendor-profile-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="multivendors-filter">
                            <div class="follow">
                                <div class="img">
                                    <img src="{{ asset('uploads/sellers/'.$seller->image) }}" alt="">
                                </div>
                                <div class="content">
                                    <h5>{{ __($seller->company_name) }}</h5>
                                    {{-- <a href="">{{ __('Follow +') }}</a> --}}
                                </div>
                            </div>
                            <div class="page-tabs">
                                <ul>
                                    <li><a href="{{ __('shop.html') }}">{{ __('Home Page') }}</a></li>
                                    <li><a href="{{ route('seller.product',$seller->slug) }}">{{ __('All Products') }}</a></li>
                                    <li><a class="active" href="{{ route('seller.profile',$seller->slug) }}">{{ __('Profile') }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="profile-left-sidebar">
                            <div class="sellar-rating">
                                <h4 class="mb-2">{{ __('Seller Ratings') }}</h4>
                                <h3 >{{ number_format($average_rating, 2) }}/<sub class="text-secondary">5</sub></h3>
                                <div class="rateit" data-rateit-value="{{ $average_rating }}" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
                                <div class="seller-progress-wrapper">
                                    <div class="seller-progress">
                                        <span>{{ __('Positive') }}</span>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $positive }}%" aria-valuenow="{{ $positive }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <small>{{ $positive }}</small>
                                    </div>
                                    <div class="seller-progress">
                                        <span>{{ __('Neutral') }}</span>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $neutral }}%" aria-valuenow="{{ $neutral }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <small>{{ $neutral }}</small>
                                    </div>
                                    <div class="seller-progress">
                                        <span>{{ __('Negative') }}</span>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $negative }}%" aria-valuenow="{{ $negative }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <small>{{ $negative }}</small>
                                    </div>
                                </div>
                                <p>{{ __('Based on') }} <b>{{ $total_reviews }}</b> {{ __('customer reviews') }}</p>
                            </div>
                            <div class="join-date">
                                <h6>{{ __('Joined') }} ({{ Carbon\Carbon::createFromTimeStamp(strtotime($seller->created_at))->diffForHumans() }})</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="seller-review-wrapper">
                            <div class="seller-review-title">
                                <h5>{{ __('Seller Ratings and Reviews') . ' ('.$total_reviews.')' }}</h5>
                            </div>
                            @foreach ($ratings as $rating)
                            <div class="seller-review-items">
                                <div class="left-side">
                                    <div class="rate">
                                        @if (in_array($rating->review_point, [4,5]))
                                        <img src="{{ asset('frontend/img/multi-vendors/icon/happy.png') }}" alt="">
                                        <span>{{ __('Positive') }}</span>
                                        @elseif (in_array($rating->review_point, [3,2]))
                                        <img src="{{ asset('frontend/img/multi-vendors/icon/neutral.png') }}" alt="">
                                        <span>{{ __('Neutral') }}</span>
                                        @elseif ($rating->review_point == 1)
                                        <img src="{{ asset('frontend/img/multi-vendors/icon/angry.png') }}" alt="">
                                        <span class="text-danger">{{ __('Negative') }}</span>
                                        @endif
                                    </div>
                                    <div class="reviewer">
                                        <label>{{ Str::limit($rating->user->first_name ?? 'ABC', 3, '***') }} - </label>
                                        <span>
                                            <img src="{{ asset('frontend/img/multi-vendors/icon/1.png') }}" alt="">
                                            <span> Verified Purchase </span>
                                        </span>
                                    </div>
                                    <div class="review-like">
                                        <span>
                                            <a href="javascript:void(0)"><img src="{{ asset('frontend/img/multi-vendors/icon/Ei-like.svg') }}" alt=""></a>
                                            <span>0</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="produtct-rating-wrapper">
                            <div class="seller-review-title">
                                <h5>{{ __('Seller Ratings and Reviews') . ' ('.$total_reviews.')' }}</h5>
                            </div>
                            @foreach ($ratings as $rating)
                            <div class="product-rating-items">
                                <div class="seller-img">
                                    <img class="rounded-circle" src="{{ asset($rating->user->image ? 'frontend/img/users/'. $rating->user->image : 'frontend/img/multi-vendors/shop/2.jpeg') }}" alt="">
                                </div>
                                <div class="product-ratign-discription-wrapper">
                                    <div class="meta-info">
                                        @for ($i = 0; $i < $rating->review_point; $i++)
                                        <i class="fa-solid fa-star text-warning"></i>
                                        @endfor
                                    </div>
                                    <div class="content">
                                        <h6>{{ Str::limit($rating->user->first_name ?? 'ABC', 3, '***') }} - </h6>
                                        <p>{{ $rating->review_note }}</p>
                                        {{-- <div class="img"><img src="{{ asset('frontend/img/multi-vendors/shop/2.jpeg') }}" alt=""></div> --}}
                                        <div class="reviewer">
                                            <span>
                                                @if (in_array($rating->review_point, [4,5]))
                                                <img src="{{ asset('frontend/img/multi-vendors/icon/happy.png') }}" alt="">
                                                @elseif (in_array($rating->review_point, [3,2]))
                                                <img src="{{ asset('frontend/img/multi-vendors/icon/neutral.png') }}" alt="">
                                                @elseif ($rating->review_point == 1)
                                                <img src="{{ asset('frontend/img/multi-vendors/icon/angry.png') }}" alt="">
                                                @endif
                                                <span> Verified Purchase </span>
                                            </span>
                                        </div>
                                        <div class="review-like">
                                            <span>
                                                <a href=""><img src="{{ asset('frontend/img/multi-vendors/icon/Ei-like.svg') }}" alt=""></a>
                                                <span>0</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
