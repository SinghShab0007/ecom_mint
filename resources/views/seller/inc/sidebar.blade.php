<!-- Left side column. contains the name and sidebar -->
<nav class="side-bar no-print">
    <div class="side-bar-logo">
        <a href="{{route('seller.home')}}">
            <img src="@if(config('app.backend_logo')){{asset(config('app.backend_logo'))}}@endif" alt="logo">
        </a>
        <button class="close-btn"></button>
    </div>
    <!-- Side Manu Start -->
    <div class="side-bar-manu">
        <ul>
            @if(auth()->user()->can('browse_dashboard') || auth()->user()->hasRole('super-admin'))
                <li>
                    <a class="@if(Request::is('seller'))active @endif"
                       href="{{route('seller.home')}}">
                        <span class="icon"><svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <rect y="11.4258" width="5.71281" height="8.56921" rx="1"/>
                                <rect x="7.14062" width="5.71281" height="19.9948" rx="1"/>
                                <rect x="14.2852" y="5.71094" width="5.71281" height="14.282" rx="1"/>
                                </svg>
                    </span>
                        <span class="title">  {{ __('Dashboard') }} </span>
                    </a>
                </li>
            @endif
            <!--start orders -->
            @if(Module::has('OrderManagement') && Module::find('OrderManagement')->isEnabled())
                @if(auth()->user()->can('browse_order_management') || auth()->user()->hasRole('super-admin'))
                    <li class="@if(Request::is('seller/*_orders','seller/orders','seller/orders/*')) active  @endif ">
                        <a href="javascript:void(0)">
                    <span class="icon">
                            <svg viewBox="0 0 16 14" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.78125 9.30273H4.25001V10.7715H4.78125V9.30273Z"/>
                                <path d="M6.90625 9.79102H6.375V10.7702H6.90625V9.79102Z"/>
                                <path
                                    d="M10.3594 11.9939V13.9522H9.03125V13.2178C9.03125 12.3667 9.42836 11.6015 10.0582 11.0645C10.2529 11.3406 10.3594 11.6627 10.3594 11.9939Z"/>
                                <path
                                    d="M1.32812 7.34375H7.70312C7.84975 7.34375 7.96875 7.45342 7.96875 7.58854V11.5052C7.96875 11.6403 7.84975 11.7499 7.70312 11.7499H1.32812C1.1815 11.7499 1.0625 11.6403 1.0625 11.5052V7.58854C1.0625 7.45342 1.1815 7.34375 1.32812 7.34375ZM1.59375 11.2604H7.4375V9.30206H5.84375V10.7708H5.3125V8.81248H3.71875V10.7708H3.1875V7.83333H1.59375V11.2604Z"/>
                                <path d="M2.65625 8.32227H2.125V10.7702H2.65625V8.32227Z"/>
                                <path
                                    d="M12.2188 9.79097C11.3385 9.79097 10.625 9.1334 10.625 8.32224C10.625 7.51109 11.3385 6.85352 12.2188 6.85352C13.099 6.85352 13.8125 7.51109 13.8125 8.32224C13.8125 9.1334 13.099 9.79097 12.2188 9.79097Z"/>
                                <path
                                    d="M12.2187 11.5043C12.8551 11.5043 13.3877 11.0889 13.5163 10.5374C13.6714 10.6012 13.8202 10.6759 13.9609 10.7611C13.6935 11.1241 13.5468 11.5525 13.5468 11.9938V13.9522H10.8906V11.9938C10.8906 11.5525 10.744 11.1241 10.4765 10.7608C10.6173 10.6757 10.766 10.6012 10.9211 10.5371C11.0497 11.0889 11.5823 11.5043 12.2187 11.5043ZM11.9531 13.4626H12.4843V12.973H11.9531V13.4626ZM11.9531 12.4834H12.4843V11.9938H11.9531V12.4834Z"/>
                                <path
                                    d="M15.4062 13.2178V13.9522H14.0781V11.9939C14.0781 11.6627 14.1846 11.3406 14.3793 11.0645C15.0091 11.6015 15.4062 12.3667 15.4062 13.2178Z"/>
                                <path
                                    d="M13.0039 10.3756C12.9532 10.7361 12.6219 11.0164 12.2174 11.0164C11.8128 11.0164 11.4816 10.7361 11.4309 10.3756C11.6829 10.3163 11.9457 10.2812 12.2174 10.2812C12.4891 10.2812 12.7518 10.3163 13.0039 10.3756Z"/>
                                <path
                                    d="M13.2812 6.63005C12.9683 6.46262 12.606 6.36519 12.2187 6.36519C11.0471 6.36519 10.0937 7.24374 10.0937 8.3235H8.5V7.58913C8.5 7.18425 8.14247 6.85477 7.70312 6.85477H1.32812C0.88878 6.85477 0.531248 7.18425 0.531248 7.58913V8.3235H-1.90735e-06V1.95898H13.2812V6.63005ZM1.59375 5.87561H2.125V5.38603H1.59375V5.87561ZM0.531248 5.87561H1.0625V5.38603H0.531248V5.87561ZM0.531248 4.89645H4.78125V4.40688H0.531248V4.89645ZM5.84375 2.44856H0.531248V2.93814H5.84375V2.44856ZM6.90625 2.44856H6.375V2.93814H6.90625V2.44856ZM6.90625 3.42772H0.531248V3.9173H6.90625V3.42772ZM6.90625 4.40688H5.3125V4.89645H6.90625V4.40688ZM6.90625 5.38603H2.65625V5.87561H6.90625V5.38603ZM12.75 2.44856H7.4375V5.87561H12.75V2.44856Z"/>
                                <path
                                    d="M13.2812 0V1.46872H-1.90735e-06V0H13.2812ZM12.2187 0.979146H12.75V0.489573H12.2187V0.979146ZM11.1562 0.979146H11.6875V0.489573H11.1562V0.979146ZM10.0937 0.979146H10.625V0.489573H10.0937V0.979146Z"/>
                                <path d="M12.2188 2.9375H7.96875V5.38539H12.2188V2.9375Z"/>
                            </svg></span>
                            <span class="title">{{ __('Order Management') }}</span>
                            <span class="arrow">
                                <svg viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg">
                                    <line x1="1.47082" y1="2" x2="6.32702" y2="6.8562" stroke-linecap="round"/>
                                    <line x1="0.75" y1="-0.75" x2="7.61771" y2="-0.75"
                                          transform="matrix(-0.707107 0.707107 0.707107 0.707107 12.3281 2)"
                                          stroke-linecap="round"/>
                                </svg>
                    </span>
                        </a>
                        <ul>
                            @if(auth()->user()->can('browse_orders') || auth()->user()->hasRole('super-admin'))
                                <li>
                                    <a class="@if(Request::is('seller/orders'))active @endif"
                                       href="{{route('seller.orders.index')}}">
                                        {{ __('Order List') }}
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->can('browse_pending_orders') || auth()->user()->hasRole('super-admin'))
                                <li><a class="@if(Request::is('seller/pending_orders'))active @endif"
                                       href="{{route('seller.pending_orders')}}">
                                        {{ __('Pending') }}
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->can('browse_confirmed_orders') || auth()->user()->hasRole('super-admin'))
                                <li>
                                    <a class="@if(Request::is('seller/confirmed_orders'))active @endif" href="{{route('seller.confirmed_orders')}}">
                                        {{ __('Confirmed') }}
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->can('browse_processing_orders') || auth()->user()->hasRole('super-admin'))
                                <li>
                                    <a class="@if(Request::is('seller/processing_orders'))active @endif"
                                       href="{{route('seller.processing_orders')}}">
                                        {{ __('Processing') }}
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->can('browse_picked_orders') || auth()->user()->hasRole('super-admin'))
                                <li>
                                    <a class="@if(Request::is('seller/picked_orders'))active @endif"
                                       href="{{route('seller.picked_orders')}}">
                                        {{ __('Picked')}}
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->can('browse_shipped_orders') || auth()->user()->hasRole('super-admin'))
                                <li><a class="@if(Request::is('seller/shipped_orders'))active @endif"
                                       href="{{route('seller.shipped_orders')}}">
                                        {{ __('Shipped') }}
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->can('browse_delivered_orders') || auth()->user()->hasRole('super-admin'))
                                <li><a class="@if(Request::is('seller/delivered_orders'))active @endif"
                                       href="{{route('seller.delivered_orders')}}">
                                        {{ __('Delivered') }} </a>
                                </li>
                            @endif
                            @if(auth()->user()->can('browse_cancelled_orders') || auth()->user()->hasRole('super-admin'))
                                <li><a class="@if(Request::is('seller/cancelled_orders'))active @endif"
                                       href="{{route('seller.cancelled_orders')}}">
                                        {{ __('Cancelled') }} </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
            @endif
            <!--end orders -->
            <!--start Product Management -->
            @if(Module::has('ProductManagement') && Module::find('ProductManagement')->isEnabled())
                @if(auth()->user()->can('browse_product_management') || auth()->user()->hasRole('super-admin'))
                    <li class="@if(Request::is('seller/products', 'seller/products/*','seller/categories','seller/categories/*','seller/brands','seller/brands/*')) active  @endif">
                        <a href="#">
                    <span class="icon">
                                <svg viewBox="0 0 22 25" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.3101 11.4708L11.4114 24.1705L22.0005 18.6209V6.125L11.3101 11.4708Z"/>
                                    <path
                                        d="M17.6499 3.52539L7.1084 8.97609L10.9468 10.9257L21.5181 5.56315L17.6499 3.52539Z"/>
                                    <path
                                        d="M14.7189 1.98175L10.958 0L0.405762 5.57106L4.06777 7.43126L14.7189 1.98175Z"/>
                                    <path
                                        d="M6.72817 14.531L5.11108 13.4121L3.73112 13.5312V8.01856L0 6.125V18.5911L10.5713 24.1705V11.4875L6.75916 9.55463L6.72817 14.531Z"/>
                                </svg>
                    </span>
                            <span class="title">{{ __('Product Management') }}</span>
                            <span class="arrow">
                                <svg viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg">
                                    <line x1="1.47082" y1="2" x2="6.32702" y2="6.8562" stroke-linecap="round"/>
                                    <line x1="0.75" y1="-0.75" x2="7.61771" y2="-0.75"
                                          transform="matrix(-0.707107 0.707107 0.707107 0.707107 12.3281 2)"
                                          stroke-linecap="round"/>
                                </svg>
                    </span>
                        </a>
                        <!-- Sub Manu Start -->
                        <ul>
                            @if(auth()->user()->can('browse_products') || auth()->user()->hasRole('super-admin'))
                                <li>
                                    <a class="@if(Request::is('seller/products','seller/products/*/edit'))active @endif"
                                       href="{{route('seller.product.index')}}">{{ __('All Product') }}
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->can('create_products') || auth()->user()->hasRole('super-admin'))
                                <li>
                                    <a class="@if(Request::is('seller/product/create'))active @endif"
                                       href="{{route('seller.product.create')}}">{{__('Add Product')}}</a>
                                </li>
                            @endif
                            @if(auth()->user()->can('browse_categories') || auth()->user()->hasRole('super-admin'))
                                <li>
                                    <a class="@if(Request::is('seller/categories','seller/categories/*/edit'))active @endif"
                                       href="{{route('seller.categories.index')}}"> {{ __('Category') }} </a>
                                </li>
                            @endif

                            @if(auth()->user()->can('create_categories') || auth()->user()->hasRole('super-admin'))
                                <li>
                                    <a class="@if(Request::is('seller/categories/create'))active @endif"
                                       href="{{route('seller.categories.create')}}"> {{ __('Add Category') }} </a>
                                </li>
                            @endif
                            @if(auth()->user()->can('browse_brands') || auth()->user()->hasRole('super-admin'))
                                <li><a class="@if(Request::is('seller/brands','seller/brands/*/edit'))active @endif"
                                       href="{{route('seller.brands.index')}}"> {{ __('Brand') }} </a>
                                </li>
                            @endif
                            @if(auth()->user()->can('create_brands') || auth()->user()->hasRole('super-admin'))
                                <li><a class="@if(Request::is('seller/brands/create'))active @endif"
                                       href="{{route('seller.brands.create')}}"> {{ __('Add Brand') }} </a>
                                </li>
                            @endif
                        </ul>
                        <!-- Sub Manu End -->
                    </li>
                @endif
            @endif
            <!--start Promotional Product Management -->
            <!--Start Finance -->
            @if(Module::has('Finance') && Module::find('Finance')->isEnabled())
                @if(auth()->user()->can('browse_product_management') || auth()->user()->hasRole('super-admin'))
                    <li class="@if(Request::is('seller/products', 'seller/products/*','seller/categories','seller/categories/*','seller/brands','seller/brands/*')) active  @endif">
                        <a href="#">
                    <span class="icon">
                                <svg viewBox="0 0 22 25" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.3101 11.4708L11.4114 24.1705L22.0005 18.6209V6.125L11.3101 11.4708Z"/>
                                    <path
                                        d="M17.6499 3.52539L7.1084 8.97609L10.9468 10.9257L21.5181 5.56315L17.6499 3.52539Z"/>
                                    <path
                                        d="M14.7189 1.98175L10.958 0L0.405762 5.57106L4.06777 7.43126L14.7189 1.98175Z"/>
                                    <path
                                        d="M6.72817 14.531L5.11108 13.4121L3.73112 13.5312V8.01856L0 6.125V18.5911L10.5713 24.1705V11.4875L6.75916 9.55463L6.72817 14.531Z"/>
                                </svg>
                    </span>
                            <span class="title">{{ __('Finance') }}</span>
                            <span class="arrow">
                                <svg viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg">
                                    <line x1="1.47082" y1="2" x2="6.32702" y2="6.8562" stroke-linecap="round"/>
                                    <line x1="0.75" y1="-0.75" x2="7.61771" y2="-0.75"
                                          transform="matrix(-0.707107 0.707107 0.707107 0.707107 12.3281 2)"
                                          stroke-linecap="round"/>
                                </svg>
                    </span>
                        </a>
                        <!-- Sub Manu Start -->
                        <ul>
                            @if(auth()->user()->can('browse_products') || auth()->user()->hasRole('super-admin'))
                                <li>
                                    <a class="@if(Request::is('seller/products','seller/products/*/edit'))active @endif"
                                       href="{{route('seller.product.index')}}">{{ __('Account Statement') }}
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->can('create_product') || auth()->user()->hasRole('super-admin'))
                                <li>
                                    <a class="@if(Request::is('seller/product/create'))active @endif"
                                       href="{{route('seller.product.create')}}">{{__('Order Overview')}}</a>
                                </li>
                            @endif
                        </ul>
                        <!-- Sub Manu End -->
                    </li>
                @endif
            @endif
            <!--start Promotional Product Management -->
            @if(Module::has('PromotionManagement') && Module::find('PromotionManagement')->isEnabled())
                @if(auth()->user()->can('browse_promotion_management') || auth()->user()->hasRole('super-admin'))
                    <li class="@if(Request::is('seller/promotional_products','seller/promotional_products/*')) active  @endif">
                        <a href="#">
                    <span class="icon">
                                <svg viewBox="0 0 22 25" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.3101 11.4708L11.4114 24.1705L22.0005 18.6209V6.125L11.3101 11.4708Z"/>
                                    <path
                                        d="M17.6499 3.52539L7.1084 8.97609L10.9468 10.9257L21.5181 5.56315L17.6499 3.52539Z"/>
                                    <path
                                        d="M14.7189 1.98175L10.958 0L0.405762 5.57106L4.06777 7.43126L14.7189 1.98175Z"/>
                                    <path
                                        d="M6.72817 14.531L5.11108 13.4121L3.73112 13.5312V8.01856L0 6.125V18.5911L10.5713 24.1705V11.4875L6.75916 9.55463L6.72817 14.531Z"/>
                                </svg>
                    </span>
                            <span class="title">{{ __('promotional List') }}</span>
                            <span class="arrow">
                                <svg viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg">
                                    <line x1="1.47082" y1="2" x2="6.32702" y2="6.8562" stroke-linecap="round"/>
                                    <line x1="0.75" y1="-0.75" x2="7.61771" y2="-0.75"
                                          transform="matrix(-0.707107 0.707107 0.707107 0.707107 12.3281 2)"
                                          stroke-linecap="round"/>
                                </svg>
                    </span>
                        </a>
                        <!-- Sub Manu Start -->
                        <ul>
                            @if(auth()->user()->can('browse_promotional_products') || auth()->user()->hasRole('super-admin'))
                                <li>
                                    <a class="@if(Request::is('seller/promotional_products'))active @endif"
                                       href="{{route('seller.promotional_products.index')}}">{{ __('Promotional Product') }}
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->can('create_promotional_products') || auth()->user()->hasRole('super-admin'))
                                <li>
                                    <a class="@if(Request::is('seller/promotional_products/create'))active @endif"
                                       href="{{route('seller.promotional_products.create')}}"> {{ __('Add Products') }} </a>
                                </li>
                            @endif
                        </ul>
                        <!-- Sub Manu End -->
                    </li>
                @endif
            @endif
            @if(auth()->user()->can('browse_content_management') || auth()->user()->hasRole('super-admin'))
                <li class="@if(Request::is('seller/banners','seller/banners/*','seller/product_review','seller/product_review/*')) active  @endif">
                    <a href="#"><span class="icon"><svg viewBox="0 0 23 21" xmlns="http://www.w3.org/2000/svg"><path
                                    d="M19.013 10.4602H20.3182V3.9342H15.75V5.23941H19.013V10.4602Z"/><path
                                    d="M3.26224 5.23941H6.52526V3.9342H1.95703V10.4602H3.26224V5.23941Z"/><path
                                    d="M20.2532 16.1689C20.6971 15.7008 20.9703 15.0692 20.9703 14.3746C20.9703 12.9352 19.7993 11.7642 18.3599 11.7642C16.9205 11.7642 15.7495 12.9352 15.7495 14.3746C15.7495 15.0692 16.0227 15.7008 16.4667 16.1689C15.7006 16.5939 15.0911 17.2682 14.7489 18.0816C14.4066 17.2682 13.7971 16.594 13.031 16.1689C13.475 15.7008 13.7482 15.0692 13.7482 14.3746C13.7482 12.9352 12.5772 11.7642 11.1378 11.7642C9.69839 11.7642 8.52736 12.9352 8.52736 14.3746C8.52736 15.0692 8.80058 15.7008 9.24453 16.1689C8.47842 16.5939 7.86897 17.2682 7.5267 18.0816C7.18443 17.2682 6.57494 16.594 5.80887 16.1689C6.25282 15.7008 6.52604 15.0692 6.52604 14.3746C6.52604 12.9352 5.35501 11.7642 3.91562 11.7642C2.47624 11.7642 1.30521 12.9352 1.30521 14.3746C1.30521 15.0692 1.57843 15.7008 2.02238 16.1689C0.817452 16.8373 0 18.1226 0 19.5954V20.248H22.2756V19.5954C22.2756 18.1226 21.4581 16.8373 20.2532 16.1689Z"/><path
                                    d="M15.0534 8.50117C15.0534 7.02838 14.236 5.74309 13.031 5.0747C13.475 4.60652 13.7482 3.97493 13.7482 3.28034C13.7482 1.84095 12.5772 0.669922 11.1378 0.669922C9.69841 0.669922 8.52738 1.84095 8.52738 3.28034C8.52738 3.97493 8.8006 4.60652 9.24454 5.0747C8.03962 5.74309 7.22217 7.02838 7.22217 8.50117V9.15378H15.0534V8.50117Z"/></svg>
                          </span>
                        <span class="title">{{__('Content Management')}}</span>
                        <span class="arrow"><svg viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg">
                                    <line x1="1.47082" y1="2" x2="6.32702" y2="6.8562" stroke-linecap="round"/>
                                    <line x1="0.75" y1="-0.75" x2="7.61771" y2="-0.75"
                                          transform="matrix(-0.707107 0.707107 0.707107 0.707107 12.3281 2)"
                                          stroke-linecap="round"/>
                                </svg></span>
                    </a>
                    <!-- Sub Manu Start -->
                    <ul>
                        <li>
                            <a class="@if(Request::is('seller/banners','seller/banners/*'))active @endif"
                               href="{{route('seller.banners.index')}}">{{ __('Banner') }}
                            </a>
                        </li>
                        <li>
                            <a class="@if(Request::is('seller/product_review'))active @endif"
                               href="{{route('seller.product_review.index')}}">{{ __('Product Review') }}
                            </a>
                        </li>
                    </ul>
                    <!-- Sub Manu End -->
                </li>@endif
            @if(auth()->user()->can('browse_reports') || auth()->user()->hasRole('super-admin'))
                <li class="@if(Request::is('seller/stock_report','seller/seller_report','seller/customer_report')) active  @endif">
                    <a href="#"><span class="icon"><svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <rect y="11.4258" width="5.71281" height="8.56921" rx="1"/>
                                <rect x="7.14062" width="5.71281" height="19.9948" rx="1"/>
                                <rect x="14.2852" y="5.71094" width="5.71281" height="14.282" rx="1"/>
                                </svg></span>
                        <span class="title">{{__('Report')}}</span>
                        <span class="arrow"><svg viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg">
                                    <line x1="1.47082" y1="2" x2="6.32702" y2="6.8562" stroke-linecap="round"/>
                                    <line x1="0.75" y1="-0.75" x2="7.61771" y2="-0.75"
                                          transform="matrix(-0.707107 0.707107 0.707107 0.707107 12.3281 2)"
                                          stroke-linecap="round"/>
                                </svg></span>
                    </a>
                    <!-- Sub Manu Start -->
                    <ul>
                        <li>
                            <a class="@if(Request::is('seller/stock_report'))active @endif"
                               href="{{route('seller.stock_report')}}">{{ __('Product (Stock balance)') }}
                            </a>
                        </li>
                        <li>
                            <a class="@if(Request::is('seller/customer_report'))active @endif"
                               href="{{route('seller.customer_report')}}">{{ __('Customer Transaction') }}
                            </a>
                        </li>
                    </ul>
                    <!-- Sub Manu End -->
                </li>
            @endif

            @if(auth()->user()->can('browse_wallet') || auth()->user()->hasRole('super-admin'))
                <li class="@if(Request::is('seller/earning','seller/withdraw_earning')) active  @endif">
                    <a href="#"><span class="icon"><svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <rect y="11.4258" width="5.71281" height="8.56921" rx="1"/>
                                <rect x="7.14062" width="5.71281" height="19.9948" rx="1"/>
                                <rect x="14.2852" y="5.71094" width="5.71281" height="14.282" rx="1"/>
                                </svg></span>
                        <span class="title">{{__('Wallet')}}</span>
                        <span class="arrow"><svg viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg">
                                    <line x1="1.47082" y1="2" x2="6.32702" y2="6.8562" stroke-linecap="round"/>
                                    <line x1="0.75" y1="-0.75" x2="7.61771" y2="-0.75"
                                          transform="matrix(-0.707107 0.707107 0.707107 0.707107 12.3281 2)"
                                          stroke-linecap="round"/>
                                </svg></span>
                    </a>
                    <!-- Sub Manu Start -->
                    <ul>
                        <li>
                            <a class="@if(Request::is('seller/earning'))active @endif"
                               href="{{route('seller.earning')}}">{{ __('Earning') }}
                            </a>
                        </li>
                        <li>
                            <a class="@if(Request::is('seller/withdraw_earning'))active @endif"
                               href="{{route('seller.withdraw_earning')}}">{{ __('Withdraw') }}
                            </a>
                        </li>
                    </ul>
                    <!-- Sub Manu End -->
                </li>
            @endif
        </ul>
    </div>
    <!-- Side Manu End -->
</nav>

