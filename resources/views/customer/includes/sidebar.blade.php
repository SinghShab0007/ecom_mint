@php
    $dashUser = auth('customer')->user();
    $dashName = $dashUser ? trim($dashUser->first_name . ' ' . $dashUser->last_name) : '';
    $dashName = $dashName !== '' ? $dashName : ($dashUser->username ?? __('Customer'));
@endphp

<!-- Dashboard Sidebar Start -->
<aside class="pk-dash-sidebar" id="pkDashSidebar">

    <button class="pk-dash-close" type="button" aria-label="{{ __('Close menu') }}">&times;</button>

    @if($dashUser)
        <div class="pk-dash-user">
            <div class="pk-dash-avatar">
                <img src="{{ $dashUser->avatar_url }}" alt="{{ $dashName }}"
                     onerror="this.src='{{ asset('frontend/img/users/default.png') }}';this.onerror=null;">
            </div>
            <div class="pk-dash-user-meta">
                <strong>{{ $dashName }}</strong>
                <span>{{ $dashUser->email }}</span>
            </div>
        </div>
    @endif

    <nav class="pk-dash-nav">
        <p class="pk-dash-nav-label">{{ __('My Account') }}</p>
        <ul>
            @if($dashUser)
                <li>
                    <a href="{{ route('customer.order') }}" class="{{ isActiveMenu(['home','order']) }}">
                        <span class="pk-ic">&#9636;</span>
                        <span>{{ __('Dashboard') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('customer.order') }}" class="{{ isActiveMenu('order/*') }}">
                        <span class="pk-ic">&#128230;</span>
                        <span>{{ __('My Orders') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('customer.profile') }}" class="{{ isActiveMenu('profile') }}">
                        <span class="pk-ic">&#128100;</span>
                        <span>{{ __('My Profile') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('wishlist') }}" class="{{ isActiveMenu('wishlist') }}">
                        <span class="pk-ic">&#9825;</span>
                        <span>{{ __('Wishlist') }}</span>
                        @if(wishlistCount() > 0)<em class="pk-dash-badge">{{ wishlistCount() }}</em>@endif
                    </a>
                </li>
            @endif
            <li>
                <a href="{{ route('customer.announcement') }}" class="{{ isActiveMenu('announcement') }}">
                    <span class="pk-ic">&#128226;</span>
                    <span>{{ __('Announcements') }}</span>
                </a>
            </li>
        </ul>

        <p class="pk-dash-nav-label">{{ __('Shop') }}</p>
        <ul>
            <li>
                <a href="{{ url('shop') }}">
                    <span class="pk-ic">&#128717;</span>
                    <span>{{ __('Continue Shopping') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ url('page/contact') }}">
                    <span class="pk-ic">&#9993;</span>
                    <span>{{ __('Help & Support') }}</span>
                </a>
            </li>
            @if($dashUser)
                <li>
                    <a href="{{ route('customer.logout') }}" class="pk-dash-logout">
                        <span class="pk-ic">&#8618;</span>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
</aside>
<span class="pk-dash-overlay" id="pkDashOverlay"></span>
<!-- Dashboard Sidebar End -->
