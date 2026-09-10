
<div class="manu-bar manu-bar--inline-categories">
    <div class="container">
        <div class="row align-items-center g-0">
            <div class="col-12">
                <nav class="main-manu manu-bar__main" aria-label="{{ __('Categories') }}">
                    <button type="button" class="close-btn" aria-label="{{ __('Close') }}">
                        <span></span>
                        <span></span>
                    </button>
                    <div class="manu-bar__category-scroll">
                    <ul class="manu-bar__category-strip">
                        <li>
                            <a href="{{ url('shop') }}" class="manu-bar__strip-link {{ isActiveMenu('shop') }}">{{ __('All Products') }}</a>
                        </li>
                        @foreach(menus() as $menu)
                            <li class="manu-bar__cat-item @if($menu->subCategories->count()) manu-bar__cat-item--has-mega @endif">
                                <a href="{{ route('category', $menu->slug ?? 'undefined') }}" class="manu-bar__strip-link manu-bar__cat-link {{ isActiveMenu($menu->slug) }}">
                                    <span>{{ $menu->name }}</span>
                                    @if($menu->subCategories->count())
                                        <span class="manu-bar__dd" aria-hidden="true"><i class="fas fa-chevron-down"></i></span>
                                    @endif
                                </a>
                                @if($menu->subCategories->count())
                                    <div class="mega-manu">
                                        <div class="container">
                                            <div class="row">
                                                @foreach($menu->subCategories as $subMenu)
                                                    <div class="col-lg-4 col-md-6">
                                                        <ul>
                                                            @if ($subMenu->subCategories->take(4)->count() > 0)
                                                                <li>
                                                                    <a href="{{ route('category', $subMenu->slug ?? 'undefined') }}">
                                                                        <h6 class="title">{{ $subMenu->name }}</h6>
                                                                    </a>
                                                                </li>
                                                                @foreach($subMenu->subCategories->take(4) as $subSubMenu)
                                                                    <li>
                                                                        <a href="{{ route('category', $subSubMenu->slug ?? 'undefined') }}">{{ $subSubMenu->name }}</a>
                                                                    </li>
                                                                @endforeach
                                                            @else
                                                                <li>
                                                                    <a href="{{ route('category', $subMenu->slug ?? 'undefined') }}">{{ $subMenu->name }}</a>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </li>
                        @endforeach
                        <li class="manu-bar__cta">
                            <a href="{{ route('seller.registration') }}" class="manu-bar__strip-link {{ isActiveMenu('/') }}">{{ __('Sale on BillMintMall') }}</a>
                        </li>
                    </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- Menu Bar End -->
