<!-- Ad Poster Start -->
@if($adPoster)
    <div class="container">
        <section class="ad-poster">
            <img src="{{ asset('frontend/img/animation/1.svg') }}" alt="" class="animation-one ">
            <img src="{{ asset('frontend/img/animation/2.svg') }}" alt="" class="animation-two">
            <img src="{{ asset('frontend/img/animation/3.svg') }}" alt="" class="animation-three">
            <img src="{{ asset('frontend/img/animation/4.svg') }}" alt="" class="animation-four">
            <img src="{{ asset('frontend/img/animation/5.svg') }}" alt="" class="animation-five">
            <img src="{{ asset('frontend/img/animation/6.png') }}" alt="" class="animation-six">
            <img src="{{ asset('frontend/img/animation/7.png') }}" alt="" class="animation-seven">
            <img src="{{ asset('frontend/img/animation/8.png') }}" alt="" class="animation-eight">
            <img src="{{ asset('frontend/img/animation/9.png') }}" alt="" class="animation-nine">
            <img src="{{ asset('frontend/img/animation/10.png') }}" alt="" class="animation-ten">
            <div class="addposter-wrapper">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="ad-post-text">
                            <h4>{{ __('New Season '). date('Y') }}</h4>
                            <h2>{{ __('Sale') }} 10 <sup>%</sup> {{ __('off') }}</h2>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="addposter-btn-wrapper">
                            <a href="{{ route('product',$adPoster->product->slug) }}" class="link-anime">{{ __('Explore Now') }} <span class="arrow"><svg viewBox="0 0 451.8 451.8"><path d="M354.7,225.9c0,8.1-3.1,16.2-9.3,22.4L151.2,442.6c-12.4,12.4-32.4,12.4-44.8,0c-12.4-12.4-12.4-32.4,0-44.7l171.9-171.9 L106.4,54c-12.4-12.4-12.4-32.4,0-44.7c12.4-12.4,32.4-12.4,44.7,0l194.3,194.3C351.6,209.7,354.7,217.8,354.7,225.9z"></path></svg></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Ad Poster End -->
@endif
