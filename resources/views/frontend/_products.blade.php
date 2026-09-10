{{-- Category rows: left = name, right = Shop More; below = up to $homeCategoryProductLimit products per row until $homeCategoryProductsTotalCap total --}}
@php
    $productsRemainingTotal = $homeCategoryProductsTotalCap;
@endphp
@foreach($shopCategories as $category)
    @if(!$category->products->isEmpty() && $productsRemainingTotal > 0)
        @php
            $countForThisRow = min($homeCategoryProductLimit, $productsRemainingTotal);
            $rowProducts = $category->products->take($countForThisRow);
            $productsRemainingTotal -= $rowProducts->count();
        @endphp
        <!-- Collection Start -->
        <section class="woman-collection">
            <div class="container">
                <div class="main-title">
                    <div class="row align-items-center">
                        <div class="col-sm-8 col-md-9">
                            <h4>{{ ucfirst($category->name) }}</h4>
                        </div>
                        <div class="col-sm-4 col-md-3">
                            <div class="right-link text-md-end">
                                <a href="{{ route('category',$category->slug) }}">{{ __('Shop More') }} <span class="icon"><svg viewBox="0 0 512 512"><path d="M477.5 273L283.1 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.7-22.7c-9.4-9.4-9.4-24.5 0-33.9l154-154.7-154-154.7c-9.3-9.4-9.3-24.5 0-33.9l22.7-22.7c9.4-9.4 24.6-9.4 33.9 0L477.5 239c9.3 9.4 9.3 24.6 0 34zm-192-34L91.1 44.7c-9.4-9.4-24.6-9.4-33.9 0L34.5 67.4c-9.4 9.4-9.4 24.5 0 33.9l154 154.7-154 154.7c-9.3 9.4-9.3 24.5 0 33.9l22.7 22.7c9.4 9.4 24.6 9.4 33.9 0L285.5 273c9.3-9.4 9.3-24.6 0-34z"></path></svg></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row auto-margin-3">
                    @foreach($rowProducts as $product)
                        <div class="col-6 col-sm-4 col-md-4 col-lg-3">
                            <x-frontend.product-card :product="$product"></x-frontend.product-card>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!-- Collection End -->
    @endif
@endforeach
