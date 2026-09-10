@extends('frontend.layouts.front')

@section('title',$product->name)

@section('meta_title',$product->meta_title ?? $product->name)

@section('meta_description',$product->meta_description ?? '')

@section('meta_image',$product->meta_image)

@section('meta_url',url()->full())

@section('meta_price',currency($product->unit_price,2))

@section('meta_color','Black')

@section('content')
    @php
        $detailSizes = $product->sizes->isNotEmpty()
            ? $product->sizes
            : $product->productstock->map(function ($ps) {
                return $ps->size;
            })->filter()->unique('id');
        $detailColors = $product->colors->isNotEmpty()
            ? $product->colors
            : $product->productstock->map(function ($ps) {
                return $ps->color;
            })->filter()->unique('id');
        $requiresVariant = $detailSizes->isNotEmpty() || $detailColors->isNotEmpty();
        $specAttributes = [];
        if (! empty($product->attributes)) {
            $attrDecoded = json_decode($product->attributes, true);
            if (is_array($attrDecoded)) {
                foreach ($attrDecoded as $k => $v) {
                    if ($v === '' || $v === null) {
                        continue;
                    }
                    $specAttributes[is_string($k) ? $k : (string) $k] = is_scalar($v) ? (string) $v : json_encode($v);
                }
            }
        }
        $hasSpecTableRows = $product->barcode || $product->warranty || $product->return_policy || $product->is_refundable || $product->tags || count($specAttributes) > 0;
        $specificationItems = $product->specification_items ?? [];
        if (! is_array($specificationItems)) {
            $specificationItems = [];
        }
        $hasSpecItems = collect($specificationItems)->contains(function ($row) {
            if (! is_array($row)) {
                return false;
            }
            $l = trim((string) ($row['label'] ?? ''));
            $v = trim((string) ($row['value'] ?? ''));

            return $l !== '' || $v !== '';
        });
        $hasSpecRich = $hasSpecItems || filled($product->specification_content) || $product->pdf_specification;
        $hasSpecificationsBlock = $hasSpecTableRows || $hasSpecRich;
        /** Stock: `is_show_stock_quantity` = show numeric qty; 0 = hide number only (not “unavailable”). */
        $productInStock = ! $product->is_manage_stock || (int) $product->quantity > 0;
    @endphp

    <!-- Breadcrumb Start -->
    <nav class="breadcrumb-manu" aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('frontend.shop') }}">{{ __('Shop') }}</a></li>
                @if($product->category)
                    <li class="breadcrumb-item"><a href="{{ route('category', $product->category->slug) }}">{{ $product->category->name }}</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ \Illuminate\Support\Str::limit($product->name, 52) }}</li>
            </ol>
        </div>
    </nav>
    <!-- Breadcrumb End -->
    <!-- Shop Details Start -->
    <section class="shop-details" id="product-detail-page" data-requires-variant="{{ $requiresVariant ? '1' : '0' }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="row product-slider">
                        <div class="col-lg-3 order-2 order-lg-0 product-small-img">
                            @foreach($product->images as $index => $image)
                                <div class="main-img product-thumb {{ $index === 0 ? 'active' : '' }}"
                                     data-full="{{ asset('uploads/products/galleries/'.$image->image) }}"
                                     style="cursor:pointer; border:2px solid {{ $index === 0 ? '#c92f6d' : 'transparent' }}; border-radius:4px; margin-bottom:10px; transition:border-color .2s;">
                                    <img src="{{ asset('uploads/products/galleries/'.$image->image) }}" alt="{{ $product->name }}">
                                </div>
                            @endforeach
                        </div>
                        <div class="col-lg-9 order-0 product-big-img">
                            <div class="main-img">
                                <img id="product-main-image"
                                     src="{{ $product->images->isNotEmpty() ? asset('uploads/products/galleries/'.$product->images->first()->image) : '' }}"
                                     alt="{{ $product->name }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="product-item-details">
                        <div class="product-title">
                            @if($product->category)
                                <p class="text-muted small mb-1 text-uppercase letter-spacing-1">{{ $product->category->name }}</p>
                            @endif
                            <h1 class="h3 mb-0 fw-semibold">{{ $product->name }}</h1>
                            @if(filled($product->short_description))
                                <div class="product-short-description text-muted mt-2 mb-0 lh-base small">{!! nl2br(e($product->short_description)) !!}</div>
                            @endif
                        </div>
                        <div class="star-rating">
                            <div class="rateit" data-rateit-value="{{ $rating }}" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
                            <a href="#">({{ $product->reviews->count() }} {{ __('Review/s') }})</a>
                        </div>
                        <div class="price">
                            @if(hasPromotion($product->id))
                                <h4>{{ currency(promotionPrice($product->id),2) }} <del>{{ currency($product->unit_price,2) }}</del></h4>
                            @else
                                @if($product->discount > 0)
                                    <h4>{{ currency(($product->unit_price - $product->discount),2) }} <del>{{ currency($product->unit_price,2) }}</del></h4>
                                @else
                                    <h4>{{ currency($product->unit_price,2) }}</h4>
                                @endif
                            @endif
                        </div>

                        <div class="skustock d-flex align-items-center">
                            <div class="product-stock {{ $productInStock ? '' : 'out-stock' }}">
                                @if($product->details)
                                    @if($product->details->is_show_stock_quantity)
                                        <span class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm6.25 8.891l-1.421-1.409-6.105 6.218-3.078-2.937-1.396 1.436 4.5 4.319 7.5-7.627z" stroke="{{ $productInStock ? 'green' : 'red' }}"/></svg>
                                        </span>
                                        <span class="text">{{ $productInStock ? __('In Stock') : __('Out of stock') }} — {{ __('Qty') }}: {{ (int) $product->quantity }}</span>
                                    @else
                                        <span class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm6.25 8.891l-1.421-1.409-6.105 6.218-3.078-2.937-1.396 1.436 4.5 4.319 7.5-7.627z" stroke="{{ $productInStock ? 'green' : 'red' }}"/></svg>
                                        </span>
                                        <span class="text">{{ $productInStock ? __('In Stock') : __('Out of stock') }}</span>
                                    @endif
                                @else
                                    <span class="text">{{ __('Details Not Available') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="product-quantity">
                            <form>
                                <div class="quantity">
                                    <input type="button" value="-" class="minus">
                                    <input type="number" class="input-number" min="1" name="quantity" value="1">
                                    <input type="button" value="+" class="plus">
                                </div>
                            </form>
                        </div>
                        @if($detailSizes->isNotEmpty())
                            <div class="product-size-wrap">
                                <h6>{{ __('Size') }} : <small class="text-muted">({{ __('required') }})</small></h6>
                                <ul>
                                    @foreach($detailSizes as $size)
                                        <li>
                                            <label class="product-size">
                                                <input type="radio" name="size" value="{{ $size->name }}" data-size-id="{{ $size->id }}">
                                                <span class="checkmark">{{ $size->name }}</span>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if($detailColors->isNotEmpty())
                            <div class="product-color-wraper">
                                <h6>{{ __('Color') }} : <small class="text-muted">({{ __('required') }})</small></h6>
                                <ul>
                                    @foreach($detailColors as $color)
                                        <li>
                                            <label class="porduct-color">
                                                <input type="radio" name="color" value="{{ $color->name }}" data-color-id="{{ $color->id }}">
                                                <span class="checkmark" style="background-color: {{ $color->hex }}"></span>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="product-link">
                            <ul>
                                <li><a href="javascript:addToCart({{$product->id}})" class="link-anime add-to-card">{{ __('Add to Cart')}}</a></li>
                                <li><a href="javascript:buyNow({{$product->id}})" class="link-anime">{{ __('Buy Now') }}</a></li>
                                <li><a href="javascript:addToWishlist({{ $product->id }})" class="link-anime">{{ __('Add to Favorite') }}</a></li>
                            </ul>
                        </div>

                        <div class="product-sidebar-meta mt-4 pt-3 border-top">
                            <h6 class="text-uppercase small text-muted mb-3 fw-semibold">{{ __('Product details') }}</h6>
                            <ul class="list-unstyled product-meta-list mb-0">
                                <li class="d-flex justify-content-between gap-3 py-2 border-bottom"><span class="text-muted">{{ __('SKU') }}</span><span class="text-end fw-medium">{{ $product->sku ?: '—' }}</span></li>
                                <li class="d-flex justify-content-between gap-3 py-2 border-bottom"><span class="text-muted">{{ __('Unit') }}</span><span class="text-end fw-medium">{{ $product->unit }}</span></li>
                                <li class="d-flex justify-content-between gap-3 py-2 border-bottom"><span class="text-muted">{{ __('Min. order') }}</span><span class="text-end fw-medium">{{ $product->minimum_qty }}</span></li>
                                @if($product->category)
                                    <li class="d-flex justify-content-between gap-3 py-2 border-bottom"><span class="text-muted">{{ __('Category') }}</span><a class="text-end fw-medium text-decoration-none" href="{{ route('category', $product->category->slug) }}">{{ $product->category->name }}</a></li>
                                @endif
                                @if($product->brand)
                                    <li class="d-flex justify-content-between gap-3 py-2 border-bottom"><span class="text-muted">{{ __('Brand') }}</span><span class="text-end fw-medium">{{ $product->brand->name }}</span></li>
                                @endif
                                @if($product->seller)
                                    <li class="d-flex justify-content-between gap-3 py-2 border-bottom align-items-start"><span class="text-muted">{{ __('Sold by') }}</span>
                                        <span class="text-end fw-medium">
                                            @if(optional($product->seller)->slug)
                                                <a class="text-decoration-none" href="{{ route('seller.product', $product->seller->slug) }}">{{ $product->seller->company_name ?? $product->seller->shop_name ?? $product->seller->name ?? __('Store') }}</a>
                                            @else
                                                {{ $product->seller->company_name ?? $product->seller->shop_name ?? $product->seller->name ?? __('Store') }}
                                            @endif
                                        </span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="product-page-content border-top">
            <div class="container py-2 py-md-3">
                <div class="product-detail-tabs-wrap">
                    <div class="product-detail-tabs-nav">
                        <ul class="nav nav-pills flex-wrap gap-2 mb-0" id="productDetailTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active px-3 py-2 rounded-pill" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">{{ __('Description') }}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link px-3 py-2 rounded-pill" id="specifications-tab" data-bs-toggle="tab" data-bs-target="#specifications" type="button" role="tab" aria-controls="specifications" aria-selected="false">{{ __('Specifications') }}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link px-3 py-2 rounded-pill" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">{{ __('Reviews') }} <span class="badge bg-secondary rounded-pill">{{ $product->reviews->count() }}</span></button>
                            </li>
                        </ul>
                    </div>
                    <div class="product-detail-tabs-body tab-info pt-2">
                        <div class="tab-content" id="productDetailTabContent">
                            <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                                @if (filled($product->description))
                                    <div class="product-description-content product-detail-prose">{!! $product->description !!}</div>
                                @else
                                    <p class="text-muted mb-0">{{ __('No description has been added for this product yet.') }}</p>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="specifications" role="tabpanel" aria-labelledby="specifications-tab">
                                @if($hasSpecificationsBlock)
                                    @if($hasSpecItems || $hasSpecTableRows)
                                        <div class="table-responsive">
                                            <table class="table table-sm align-middle mb-0 product-spec-table product-spec-table--inline">
                                                <tbody>
                                                    @foreach($specificationItems as $item)
                                                        @if(is_array($item))
                                                            @php
                                                                $specLabel = trim((string) ($item['label'] ?? ''));
                                                                $specValue = trim((string) ($item['value'] ?? ''));
                                                            @endphp
                                                            @if($specLabel !== '' || $specValue !== '')
                                                                <tr>
                                                                    <th scope="row" class="bg-light text-muted fw-normal py-1">{{ $specLabel !== '' ? $specLabel : '—' }}</th>
                                                                    <td class="py-1">{{ $specValue !== '' ? $specValue : '—' }}</td>
                                                                </tr>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                    @if($product->barcode)
                                                        <tr><th scope="row" class="bg-light text-muted fw-normal py-1">{{ __('Barcode') }}</th><td class="py-1">{{ $product->barcode }}</td></tr>
                                                    @endif
                                                    @if($product->warranty)
                                                        <tr><th scope="row" class="bg-light text-muted fw-normal py-1">{{ __('Warranty') }}</th><td class="py-1">{{ $product->warranty }}</td></tr>
                                                    @endif
                                                    @if($product->return_policy)
                                                        <tr><th scope="row" class="bg-light text-muted fw-normal py-1">{{ __('Return policy') }}</th><td class="py-1">{{ $product->return_policy }}</td></tr>
                                                    @endif
                                                    @if($product->is_refundable)
                                                        <tr><th scope="row" class="bg-light text-muted fw-normal py-1">{{ __('Refundable') }}</th><td class="py-1">{{ __('Yes') }}</td></tr>
                                                    @endif
                                                    @if($product->tags)
                                                        <tr><th scope="row" class="bg-light text-muted fw-normal py-1 align-top">{{ __('Tags') }}</th><td class="py-1">{{ is_string($product->tags) ? $product->tags : json_encode($product->tags) }}</td></tr>
                                                    @endif
                                                    @foreach($specAttributes as $label => $val)
                                                        <tr><th scope="row" class="bg-light text-muted fw-normal py-1">{{ $label }}</th><td class="py-1">{{ $val }}</td></tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                    @if(filled($product->specification_content))
                                        <div class="product-description-content product-detail-prose specification-rich-content mt-2 pt-2 border-top">
                                            {!! $product->specification_content !!}
                                        </div>
                                    @elseif($product->pdf_specification && ! $hasSpecItems)
                                        <div class="product-detail-prose mt-2">
                                            <a href="{{ asset('uploads/products/pdf/'.$product->pdf_specification) }}" class="text-decoration-none" target="_blank" rel="noopener">
                                                <i class="fa-solid fa-file-pdf text-danger me-1"></i>{{ __('Download specification PDF') }}
                                            </a>
                                        </div>
                                    @endif
                                @else
                                    <p class="text-muted mb-0">{{ __('No specifications have been added for this product yet.') }}</p>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                @if($product->reviews->count() == 0)
                                    <p class="text-muted mb-2 small">{{ __('There are no reviews yet. Be the first to share your experience.') }}</p>
                                @endif

                                @foreach($product->reviews as $review)
                                    <div class="product-review-line py-2 border-bottom">
                                        <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                                            <strong class="mb-0">{{ $review->user->first_name }}</strong>
                                            <div class="rateit" data-rateit-value="{{ $review->review_point }}" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
                                        </div>
                                        <p class="mb-0 text-muted small">{{ $review->review_note }}</p>
                                    </div>
                                @endforeach
                                @if(auth('customer')->check())
                                    @if(canReview(auth('customer')->id(),$product->id))
                                        <form class="contact-form mt-3 border-top pt-3" action="{{ route('customer.review') }}" method="post">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="form-label small text-muted">{{ __('Your rating') }}</label>
                                                <input type="range" name="review_point" value="5" step="1" id="backing5" class="form-range">
                                                <div class="rateit" data-rateit-backingfld="#backing5" data-rateit-resetable="false"  data-rateit-ispreset="true" data-rateit-min="0" data-rateit-max="5">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                                <div class="col-12">
                                                    <div class="input-group">
                                                        <textarea class="form-control" name="review_note" rows="5" placeholder="{{ __('Write your review…') }}"></textarea>
                                                        <span class="label">{{ __('Your review') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn-anime mt-3">{{ __('Submit review') }}</button>
                                        </form>
                                    @elseif($pendingReview)
                                        <b>{{ __('Your review is pending') }}</b>
                                    @else
                                        <p>{{ __('You are not eligible to review this product') }}</p>
                                    @endif
                                @else
                                    <p class="mb-0">{{ __('Login to review this product') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Details End -->
    <!-- Similar Product Start -->
    <section class="similar-product py-5 bg-white">
        <div class="container">
            <div class="title-center">
                <h4>{{ __('You may also like') }}</h4>
                <p class="text-muted">{{ __('More products picked for you based on what shoppers often view next.') }}</p>
            </div>
            <div class="row auto-margin-3 g-3">
                @foreach($similarProducts as $similar)
                    <div class="col-6 col-md-3">
                        <x-frontend.product-card :product="$similar"></x-frontend.product-card>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Similar Product End -->

    @push('script')
        <script>
            (function () {
                var mainImage = document.getElementById('product-main-image');
                var thumbs = document.querySelectorAll('.product-small-img .product-thumb');
                if (!mainImage || !thumbs.length) return;

                thumbs.forEach(function (thumb) {
                    thumb.addEventListener('click', function () {
                        var full = thumb.getAttribute('data-full');
                        if (!full) return;

                        mainImage.src = full;

                        thumbs.forEach(function (t) {
                            t.classList.remove('active');
                            t.style.borderColor = 'transparent';
                        });
                        thumb.classList.add('active');
                        thumb.style.borderColor = '#c92f6d';
                    });
                });
            })();
        </script>
    @endpush
@stop
