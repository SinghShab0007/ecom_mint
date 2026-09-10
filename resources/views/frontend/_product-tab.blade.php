<!-- Product Tab Start -->
<section class="product-tab">
    <div class="container">
        <div class="tab-title">
            <h4>{{ __('Deal of the week') }}</h4>
        </div>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="all-item-tab" data-bs-toggle="tab" data-bs-target="#all-item" type="button" role="tab" aria-controls="all-item" aria-selected="true">{{ __('All item') }}</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="new-arrivals-tab" data-bs-toggle="tab" data-bs-target="#new-arrivals" type="button" role="tab" aria-controls="new-arrivals" aria-selected="false">{{ __('New Arrivals') }}</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="best-seller-tab" data-bs-toggle="tab" data-bs-target="#best-seller" type="button" role="tab" aria-controls="best-seller" aria-selected="false">{{ __('Best Seller') }}</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="our-featured-tab" data-bs-toggle="tab" data-bs-target="#our-featured" type="button" role="tab" aria-controls="our-featured" aria-selected="false">{{ __('Our Featured') }}</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="trends-tab" data-bs-toggle="tab" data-bs-target="#trends" type="button" role="tab" aria-controls="trends" aria-selected="false">{{ __('Trends') }}</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade active show" id="all-item" role="tabpanel" aria-labelledby="all-item-tab">
                <div class="row auto-margin-3">
                    @if($allProducts->count() == 0)
                        <div class="col-12">
                            <p class="text-center">{{ __('UPCOMING...') }}</p>
                        </div>
                    @endif
                    @foreach($allProducts as $product)
                        <div class="col-6 col-sm-4 col-md-4 col-lg-3">
                            <x-frontend.product-card2 :product="$product"></x-frontend.product-card2>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane fade" id="new-arrivals" role="tabpanel" aria-labelledby="new-arrivals-tab">
                <div class="row auto-margin-3">
                    @if($newArrivals->count() == 0)
                        <div class="col-12">
                            <p class="text-center">{{ __('UPCOMING...') }}</p>
                        </div>
                    @endif
                    @foreach($newArrivals as $product)
                        <div class="col-6 col-sm-4 col-md-4 col-lg-3">
                            <x-frontend.product-card2 :product="$product"></x-frontend.product-card2>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane fade" id="best-seller" role="tabpanel" aria-labelledby="best-seller-tab">
                <div class="row auto-margin-3">
                    @if($bestSellers->count() == 0)
                        <div class="col-12">
                            <p class="text-center">{{ __('UPCOMING...') }}</p>
                        </div>
                    @endif
                    @foreach($bestSellers as $product)
                        <div class="col-6 col-sm-4 col-md-4 col-lg-3">
                            <x-frontend.product-card2 :product="$product"></x-frontend.product-card2>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane fade" id="our-featured" role="tabpanel" aria-labelledby="our-featured-tab">
                <div class="row auto-margin-3">
                    @if($featureProducts->count() == 0)
                        <div class="col-12">
                            <p class="text-center">{{ __('UPCOMING...') }}</p>
                        </div>
                    @endif
                    @foreach($featureProducts as $product)
                        <div class="col-6 col-sm-4 col-md-4 col-lg-3">
                            <x-frontend.product-card2 :product="$product"></x-frontend.product-card2>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane fade" id="trends" role="tabpanel" aria-labelledby="trends-tab">
                <div class="row auto-margin-3">
                    @if($trends->count() == 0)
                        <div class="col-12">
                            <p class="text-center">{{ __('UPCOMING...') }}</p>
                        </div>
                    @endif
                    @foreach($trends as $product)
                        <div class="col-6 col-sm-4 col-md-4 col-lg-3">
                            <x-frontend.product-card2 :product="$product"></x-frontend.product-card2>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Product Tab End -->
