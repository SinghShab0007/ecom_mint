<div class="maan-mybazar-filter">
    <div class="maan-filter-wrapper">
        <div class="filter-left">
            <p class="m-0">
                @if($products->count() > 0)
                    {{ $products->firstItem() }} - {{ $products->lastItem() }} {{ __('of') }}
                @endif
                {{ $products->total() }} {{ __('Results') }}
            </p>
        </div>
        <div class="maan-filter-right">
            <select name="sorting" id="sorting">
                <option selected="selected" disabled>{{ __('SORT BY') }}</option>
                <option value="price">{{ __('Price') }}</option>
                <option value="popularity">{{ __('Popularity') }}</option>
            </select>
            <div class="nav filter-grid">
                <h5>{{ __('View') }}</h5>
                <a class="active" href="#ShopGrid" data-bs-toggle="tab">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="26" viewBox="0 0 24 26">
                        <defs>
                            <clipPath id="clip-path">
                                <rect width="24" height="26" fill="none"/>
                            </clipPath>
                        </defs>
                        <g id="Repeat_Grid_1" data-name="Repeat Grid 1" clip-path="url(#clip-path)">
                            <g transform="translate(-1676 -611)">
                                <rect id="Rectangle_146" data-name="Rectangle 146" width="6" height="6" transform="translate(1676 611)" fill="#ff8400"/>
                            </g>
                            <g transform="translate(-1667 -611)">
                                <rect id="Rectangle_146-2" data-name="Rectangle 146" width="6" height="6" transform="translate(1676 611)" fill="#ff8400"/>
                            </g>
                            <g transform="translate(-1658 -611)">
                                <rect id="Rectangle_146-3" data-name="Rectangle 146" width="6" height="6" transform="translate(1676 611)" fill="#ff8400"/>
                            </g>
                            <g transform="translate(-1676 -601)">
                                <rect id="Rectangle_146-4" data-name="Rectangle 146" width="6" height="6" transform="translate(1676 611)" fill="#ff8400"/>
                            </g>
                            <g transform="translate(-1667 -601)">
                                <rect id="Rectangle_146-5" data-name="Rectangle 146" width="6" height="6" transform="translate(1676 611)" fill="#ff8400"/>
                            </g>
                            <g transform="translate(-1658 -601)">
                                <rect id="Rectangle_146-6" data-name="Rectangle 146" width="6" height="6" transform="translate(1676 611)" fill="#ff8400"/>
                            </g>
                            <g transform="translate(-1676 -591)">
                                <rect id="Rectangle_146-7" data-name="Rectangle 146" width="6" height="6" transform="translate(1676 611)" fill="#ff8400"/>
                            </g>
                            <g transform="translate(-1667 -591)">
                                <rect id="Rectangle_146-8" data-name="Rectangle 146" width="6" height="6" transform="translate(1676 611)" fill="#ff8400"/>
                            </g>
                            <g transform="translate(-1658 -591)">
                                <rect id="Rectangle_146-9" data-name="Rectangle 146" width="6" height="6" transform="translate(1676 611)" fill="#ff8400"/>
                            </g>
                        </g>
                    </svg>
                </a>
                <a href="#ShopList" data-bs-toggle="tab">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26">
                        <g id="Group_182" data-name="Group 182" transform="translate(-1430 -578)">
                            <rect id="Rectangle_147" data-name="Rectangle 147" width="26" height="4" transform="translate(1430 578)" fill="#ff8400"/>
                            <rect id="Rectangle_148" data-name="Rectangle 148" width="26" height="4" transform="translate(1430 585)" fill="#ff8400"/>
                            <rect id="Rectangle_149" data-name="Rectangle 149" width="26" height="4" transform="translate(1430 593)" fill="#ff8400"/>
                            <rect id="Rectangle_150" data-name="Rectangle 150" width="26" height="4" transform="translate(1430 600)" fill="#ff8400"/>
                        </g>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>



<div class="tab-content">
    <div class="tab-pane fade show active" id="ShopGrid">
        <div class="row auto-margin-3">
            <!-- ** ajax loader start ** -->
            <div id="product-loader">
                <div class="overlay-content">
                    <img src="{{ asset('frontend/img/loader/bar.gif') }}" alt="Loading..." />
                </div>
            </div>
            <!-- ** ajax loader end ** -->
            @if($products->count() == 0)
                <div class="text-center">
                    <p>{{ __('Not available. Try search with different keyword') }}</p>
                </div>
            @endif
            @foreach($products as $product)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <x-frontend.product-card :product="$product"></x-frontend.product-card>
                </div>
            @endforeach
            <x-frontend.page-navigation-ajax :paginator="$products"></x-frontend.page-navigation-ajax>
        </div>
    </div>

    <!-- shop list items -->
    <div class="tab-pane fade" id="ShopList">
        <div class="row auto-margin-3" id="product-area">
            @if($products->count() == 0)
                <div class="text-center">
                    <p>{{ __('Not available. Try search with different keyword') }}</p>
                </div>
            @endif
            <div class="col-lg-12">
                @foreach($products as $product)
                    <x-frontend.product-card3 :product="$product"></x-frontend.product-card3>
                @endforeach
            </div>
            <x-frontend.page-navigation-ajax :paginator="$products"></x-frontend.page-navigation-ajax>
        </div>
    </div>
</div>

