<!-- Info Footer Start -->
<div class="info-footer">
    <div class="container">
        <div class="row">

            {{-- BRAND / ABOUT --}}
            <div class="col-lg-3 col-md-6">
                <div class="footer-left">
                    <div class="footer-logo">
                        <a href="{{ url('/') }}"><img src="{{ asset('uploads/footer-logo.png') }}" alt="{{ config('app.name') }}"></a>
                    </div>
                    <p>{{ maanAppearance('about_us') }}</p>

                    <div style="color:var(--color-border); font-size:14px; line-height:1.9;">
                        <p style="margin:0 0 10px 0;">
                            OFFICE NO. S-01, 2nd floor, G-47, Sec-3 Noida,<br>
                            Gautambuddha Nagar, UP - 201301
                        </p>
                        <p style="margin:0 0 6px 0;">
                            <a href="tel:+919211635360" style="color:#A97FD0; text-decoration:none;">+91 9211635360</a>
                        </p>
                        <p style="margin:0;">
                            <a href="mailto:contact@billmintmall.com" style="color:#A97FD0; text-decoration:none;">contact@billmintmall.com</a>
                        </p>
                    </div>
                </div>
            </div>

            {{-- ONLINE SHOPPING (categories) --}}
            <div class="col-lg-3 col-md-6">
                <h6>{{ __('Online Shopping') }}</h6>
                <ul>
                    @foreach(menus() as $menu)
                        <li><a href="{{ route('category', $menu->slug ?? 'undefined') }}">{{ $menu->name }}</a></li>
                    @endforeach
                    <li><a href="{{ url('shop') }}">{{ __('All Products') }}</a></li>
                </ul>
            </div>

            {{-- ACCOUNTS & SUPPORT --}}
            <div class="col-lg-2 col-md-4 col-6">
                <h6>{{ __('Accounts & Support') }}</h6>
                <ul>
                    <li><a href="{{ url('profile') }}">{{ __('Profile') }}</a></li>
                    <li><a href="{{ url('page/contact') }}">{{ __('Help & Support') }}</a></li>
                    <li><a href="{{ url('seller/login') }}">{{ __('Seller Login') }}</a></li>
                    <li><a href="{{ url('seller/registration') }}">{{ __('Register as Seller') }}</a></li>
                </ul>
            </div>

            {{-- QUICK LINKS --}}
            <div class="col-lg-2 col-md-4 col-6">
                <h6>{{ __('Quick Links') }}</h6>
                <ul>
                    <li><a href="{{ url('page/about-us') }}">{{ __('About Us') }}</a></li>
                    <li><a href="{{ url('page/contact') }}">{{ __('Contact Us') }}</a></li>
                    <li><a href="{{ url('new-arrivals') }}">{{ __('Latest Products') }}</a></li>
                    <li><a href="{{ url('faq') }}">{{ __('FAQ') }}</a></li>
                </ul>
            </div>

            {{-- LEGAL & POLICIES --}}
            <div class="col-lg-2 col-md-4 col-6">
                <h6>{{ __('Legal & Policies') }}</h6>
                <ul>
                    <li><a href="{{ url('page/terms-and-conditions') }}">{{ __('Terms And Conditions') }}</a></li>
                    <li><a href="{{ url('page/privacy-n-policy') }}">{{ __('Privacy Policy') }}</a></li>
                    <li><a href="{{ url('page/cancellation-policy') }}">{{ __('Cancellations, Returns & Refunds') }}</a></li>
                    <li><a href="{{ url('page/shipping-policy') }}">{{ __('Shipping Policy') }}</a></li>
                    <li><a href="{{ url('page/dispute-grievance-policy') }}">{{ __('Dispute & Grievance Policy') }}</a></li>
                </ul>
            </div>

        </div>
    </div>
</div>
<!-- Info Footer End -->
