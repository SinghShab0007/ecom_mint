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
        $hasColorVariantUi = $product->productstock->contains(function ($ps) {
            return $ps->color_id && optional($ps->color)->name;
        });
        $hasSizeVariantUi = $product->productstock->contains(function ($ps) {
            return $ps->size_id && optional($ps->size)->name;
        });
        $requiresVariant = $hasColorVariantUi || $hasSizeVariantUi;
    @endphp

    <!-- Breadcrumb Start -->
    <nav class="breadcrumb-manu" aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ url('shop') }}">{{ __('Shop') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Product') }}</li>
            </ol>
        </div>
    </nav>
    <!-- Breadcrumb End -->
    <!-- Shop Details Start -->
    <section class="shop-details multivendor-shop-details-section" id="product-detail-page" data-requires-variant="{{ $requiresVariant ? '1' : '0' }}">
        <div class="container">
            <div class="product-details-layout">
                <div class="layout-items">


                    <!-- Primary carousel image -->

                    @if($product->images->first()->image ?? false)
                        <div class="show product-zoom-thumb" href="{{ asset('uploads/products/galleries/'.$product->images->first()->image ?? '') }}" >
                            <img src="{{ asset('uploads/products/galleries/'.$product->images->first()->image ?? '') }}" id="show-img" alt="{{ $product->name }}">
                        </div>
                    @endif


                    <!-- Secondary carousel image thumbnail gallery -->

                    <div class="small-img">
                        <div class="icon-left" id="prev-img"><i class="fas fa-chevron-left"></i></div>
                        <img src="images/next-icon.png"  alt="" id="prev-img">
                        <div class="small-container">
                            <div id="small-img-roll">
                                @foreach($product->images as $image)
                                    <img src="{{ asset('uploads/products/galleries/'.$image->image) }}" class="show-small-img" alt="product-thumbnail-sm">

                                @endforeach
                            </div>
                        </div>
                        <div class="icon-right" id="next-img"><i class="fas fa-chevron-right"></i></div>
                    </div>
                </div>
                <div class="layout-items">
                    <div class="multiventors-details-middle new-product-detais">
                        <div class="title-area">
                            <h2>
                                {{ $product->name }}
                                @if ($product->video->video_link ?? false)
                                    <a target="_blank" href="{{ $product->video->video_link ?? '' }}" class="text-danger"><i class="fa-solid fa-circle-play"></i></a>
                                @endif
                            </h2>

                            <div class="multivendor-price" data-product-quantity="{{$product->quantity}}">
                                @if ($product->quantity<1 && $product->is_manage_stock)
                                    <small class="m-2">
                                        <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="19" height="19" rx="9.5" fill="red"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12.0301 6.45179L8.44376 10.2687L6.97682 8.78573C6.64346 8.44873 6.09956 8.44725 5.76435 8.78244C5.43125 9.11552 5.43032 9.65528 5.76228 9.98953L8.44378 12.6896L13.2404 7.6623C13.5746 7.32807 13.5747 6.78613 13.2404 6.45189C12.9062 6.11764 12.3643 6.11759 12.0301 6.45179ZM5.76228 6.45179L12.0301 12.7196M5.76228 12.7196L12.0301 6.45179" stroke="white" stroke-width="1.5"/>
                                        </svg>

                                        {{ __('Sold Out') }}
                                    </small>

                                @else
                                    <small class="m-2">
                                        <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="19" height="19" rx="9.5" fill="#13E291"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12.0301 6.45179L8.44376 10.2687L6.97682 8.78573C6.64346 8.44873 6.09956 8.44725 5.76435 8.78244C5.43125 9.11552 5.43032 9.65528 5.76228 9.98953L8.44378 12.6896L13.2404 7.6623C13.5746 7.32807 13.5747 6.78613 13.2404 6.45189C12.9062 6.11764 12.3643 6.11759 12.0301 6.45179Z" fill="white"/>
                                        </svg>
                                        {{ __('In Stock') }}
                                    </small>
                                @endif

                                <div class="sku-text m-2">{{__('Code:')}} {{ $product->sku }}</div>
                                @if($product->details->is_show_stock_quantity)
                                    <div class=" m-2">{{__('Stock Qty:')}} {{ $product->quantity }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="new-price-wrapper">
                            <div class="new-product-details-button-group">
                                @foreach($wholesales as $index=>$wholesale)
                                    <button class="product-qty-btn"><span class="product-min-qty">{{$wholesale->min_range}} </span>{{__('-')}}<span class="product-max-qty">{{$wholesale->max_range}} </span><span> {{__('pcs :')}}</span> <strong>{{ userCurrency('symbol') }} <span class="product-price-all">{{ userCurrency('exchange_rate') * $wholesale->price }} </span> </strong></button>
                                @endforeach
                            </div>
                            <div class="price">
                                <small>Price: </small>

                                <span>{{ userCurrency('symbol')}}
                                    @if(hasPromotion($product->id))
                                        <span id="current_price">{{promotionPrice($product->id,2) }}</span> <del>{{ currency($product->unit_price,2) }}</del>

                                        <small class="offer-percent">{{__('-')}}{{ round((($product->unit_price-promotionPrice($product->id))/$product->unit_price) *100) }} {{__('%')}}</small>

                                    @else
                                        <span id="current_price">{{ number_format(userCurrency('exchange_rate') * $product->sale_price,2) }}</span>@if ($product->discount>0) <del>{{ currency($product->unit_price,2) }}</del>

                                        <small class="offer-percent">{{__('-')}}{{ round((($product->unit_price - $product->sale_price)/$product->unit_price) *100) }} {{__('%')}}</small>
                                        @endif
                                    @endif

                                </span>
                            </div>
                        </div>

                        @if($product->productstock->count() > 0)
                            @if ($product->productstock[0]->color ?? false)
                                <div class="product-size-wrap product-size-v2">
                                    <h6>Color:</h6>
                                    <ul>
                                        @foreach($product->productstock->unique('color_id') ?? [] as $productstock)
                                            @if ($productstock->color->name ?? false)
                                                <li>
                                                    <label class="product-size">
                                                        <input name="color" {{--{{ $loop->first ? 'checked':'' }}--}} value="{{ $productstock->color->name }}" type="radio" data-color-id="{{ $productstock->color->id }}" class="color-variation">
                                                        <span class="checkmark product-color" style="background-color: {{ $productstock->color->hex }}"></span>
                                                    </label>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if ($product->productstock[0]->size ?? false)
                                <div class="product-size-wrap product-size-v2">
                                    <h6>Size:</h6>
                                    <ul>
                                        @foreach($product->productstock->unique('size_id') ?? [] as $productstock)
                                            @if ($productstock->size->name ?? false)
                                                <li>
                                                    <label class="product-size">
                                                        <input type="radio" {{--{{ $loop->first ? 'checked':'' }}--}} name="size" value="{{ $productstock->size->name ?? '' }}" data-size-id="{{ $productstock->size->id }}" class="size-variation">
                                                        <span class="checkmark">{{ $productstock->size->name ?? '' }}</span>
                                                    </label>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @endif
                        <div class="new-quantity-area">
                            {{-- <div class="new-quantity-item">
                                <select name="courier" class="form-control" id="courier">
                                    <option disabled selected value="">-{{ __('Select courier') }}-</option>
                                    @if ($product->courieres != 'null' && $product->courieres)
                                        @foreach ($product->courieres as $courier)
                                            <option value="{{ $courier }}">{{ $courier }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div> --}}
                            <div class="new-quantity-item">
                                <h5>{{__('Total Price:')}}</h5>
                                <h5>{{userCurrency('symbol')}}<span id="total_price">
                                        @if(hasPromotion($product->id))
                                            {{promotionPrice($product->id,2) }}
                                        @else
                                            {{ number_format(userCurrency('exchange_rate') * $product->sale_price,2) }}
                                        @endif</span></h5>
                                <small>{{$product->unit}}</small>
                            </div>
                        </div>
                        <div class="new-quantity-area">
                            <div class="new-quantity-item">
                                <h5>{{__('Quantity:')}}</h5>
                                <div class="product-quantity multivents-number">
                                    <form>
                                        <div class="quantity">
                                            <button type="button" class="minus" id="whole_minus" data-key="{{$product->id}}" data-id="{{ $product->id }}"><i class="fal fa-minus"></i></button>
                                            <input type="number" class="input-number" min="1" name="quantity" value="1"  data-id="{{ $product->id }}" @unless ($product->quantity && $product->is_manage_stock) readonly @endunless>
                                            <button type="button" class="plus" id="whole_plus"  data-id="{{ $product->id }}" @unless ($product->quantity && $product->is_manage_stock) disabled @endunless ><i class="fal fa-plus"></i></button>
                                        </div>

                                    </form>
                                </div>
                                @unless ($product->quantity>0)
                                    <strong><span class="text-danger">Out of stock</span></strong>
                                @endunless

                            </div>

                        </div>
                        <div class="cart-button-wrapper">
                            {{--@if ($product->quantity && $product->is_manage_stock)--}}
                            <a href="javascript:addToCart({{ $product->id }})" class="btn maan-cartbtn m-2 @unless ($product->quantity && $product->is_manage_stock) disabled @endunless">{{ __('Add to Cart') }}</a>
                            <a href="javascript:void(0)" data-buynow-url="{{ route('buynow.index', ['product_id' => $product->id]) }}" class="btn buynow-btn m-2 @unless ($product->quantity && $product->is_manage_stock) disabled @endunless">{{ __('Buy Now') }}</a>
                            <a href="javascript:addToWishlist({{ $product->id }})" class="maan-wishlist-btn m-2">
                                <i class="fa-solid fa-heart"></i>
                            </a>
                            {{--@endif--}}
                        </div>
                    </div>
                </div>
                <div class="layout-items">
                    <div class="multivendors-social mt-0 mb-2">
                        <div class="socialsharea">
                            <small>{{ __('Share') }}: </small>
                            <ul>
                                <li> <div data-href="{{ url()->full() }}" data-layout="button" data-size="small"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{url()->full()}}&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore"><i class="fa-brands fa-facebook-f"></i></a></div></li>
                                <li><a class="twitter-share-button" href="https://twitter.com/intent/tweet?text={{url()->full()}}" target="_blank"><i class="fa-brands fa-twitter"></i></a></li>
                                <li><a href="https://www.linkedin.com/sharing/share-offsite/?url={{ route('product',$product->slug) }}" target="_blank"><i class="fa-brands fa-linkedin-in"></i></a></li>
                                <li><a href="https://www.pinterest.com/pin/create/button?url={{ route('product',$product->slug) }}&media={{ asset('uploads/products/galleries') }}/{{ optional($product->images)->first()->image ?? '' }}&description={{ $product->name }}" target="_blank"><i class="fa-brands fa-pinterest-p"></i></a></li>
                                <li><a href="#" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                                <li><a href="#" target="_blank"><i class="fab fa-youtube"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    {{-- <div class="product-details-wedget">
                        <div class="wedget-items">
                            <div class="details-meta-items justify-content-between d-flex flex-wrap">
                                <p><i class="fa-solid fa-truck"></i> {{ __('Standard Delivery') }} <small>({{ optional($product->details)->inside_shipping_days }})</small></p>
                                <b>{{ optional($product->details)->is_free_shipping ? 'Free' : currency($product->shipping_cost,2) }}</b>
                            </div>
                            @if (optional($product->details)->is_cash_on_delivery)
                            <div class="details-meta-items">
                                <p><i class="fa-solid fa-hand-holding-dollar"></i> {{__('Cash on Delivery Available')}}</p>
                            </div>
                            @endif
                        </div>
                        <div class="wedget-items">
                            <div class="wedgettitle">
                                <h5>{{ __('Service') }}</h5>
                                <i class="fa-solid fa-circle-info"></i>
                            </div>
                            <ul>
                                @if (optional($product->details)->is_free_shipping)
                                <li>
                                    <i class="fa-regular fa-circle-check text-success"></i>
                                    {{__('Free shipping')}}
                                </li>
                                @endif
                                @if (optional($product->details)->is_cash_on_delivery)
                                <li>
                                    <i class="fa-regular fa-circle-check text-success"></i>
                                    {{__('Cash on Delivery')}}
                                </li>
                                @endif
                                @if ($product->warranty)
                                <li>
                                    <i class="fa-regular fa-circle-check text-success"></i>
                                    {{ $product->warranty }}
                                </li>
                                @endif
                                @if ($product->return_policy)
                                <li>
                                    <i class="fa-regular fa-circle-check text-success"></i>
                                    {{ $product->return_policy }}
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div> --}}
                    <div class="contact-infos my-3">
                        <div class="details-meta-items my-2">
                            <p class="fw-bold">
                                <i class="fas fa-thumbs-up"></i>
                                {{ __('Quality Product') }}
                            </p>
                        </div>
                        @if (optional($product->details)->is_cash_on_delivery)
                            <div class="details-meta-items my-2">
                                <p class="fw-bold"><i class="fa-solid fa-hand-holding-dollar"></i> {{ __('Cash on Delivery Available') }}</p>
                            </div>
                        @endif
                        <div class="details-meta-items justify-content-between d-flex flex-wrap my-1">
                            <p class="fw-bold">
                                <i class="fa-solid fa-truck"></i>
                                {{ __('Delivery Charge') }}
                            </p>
                        </div>
                        <div class="details-meta-items justify-content-between d-flex flex-wrap my-2">
                            <div class="form-check ps-0">
                                <input class="form-check-input" type="radio" value="inside" name="delivery_charge" id="insideCharge" checked>
                                <label class="form-check-label" for="insideCharge">
                                    {{ __('Inside Dhaka') }} ({{ optional($product->details)->inside_shipping_days }})
                                </label>
                            </div>
                            <b>
                                {{ optional($product->details)->is_free_shipping ? 'Free' : currency($product->shipping_cost, 2) }}
                            </b>
                        </div>
                        <div class="details-meta-items justify-content-between d-flex flex-wrap my-2">
                            <div class="form-check ps-0">
                                <input class="form-check-input" type="radio" value="outside" name="delivery_charge" id="outsideCharge" >
                                <label class="form-check-label" for="outsideCharge">
                                    {{ __('Outside Dhaka') }} ({{ optional($product->details)->outside_shipping_days }})
                                </label>
                            </div>
                            <b>
                                {{ optional($product->details)->is_free_shipping ? 'Free' : currency($product->outside_shipping_cost, 2) }}
                            </b>
                        </div>
                    </div>
                    <div class="contact-infos my-3">
                        @foreach (getContactsInfos() as $item)
                            <div class="single-item">
                                <h6 class="d-inline-block my-1">{{ $item->value['number'] ?? '' }}</h6> <small class="d-inline-block ms-2">{{ $item->value['title'] ?? '' }}</small>
                            </div>
                        @endforeach
                    </div>
                    @if ($product->seller)
                        <div class="product-details-wedget">
                            <div class="wedget-items">
                                <div class="details-meta-items">
                                    <div class="wrapper">
                                        <i class="fa-solid fa-store"></i>
                                        <p> {{__('Sold By: ')}} {{ optional($product->seller)->company_name ?? optional($product->seller)->first_name }}</p>
                                    </div>
                                </div>
                            </div>
                            @if (optional($product->seller)->slug)
                                <a href="{{ route('seller.product', optional($product->seller)->slug) }}" class="store-visite-btn">{{ __('Visit Store') }}</a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            <div class="tab-info">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="specifications-tab" data-bs-toggle="tab" data-bs-target="#specifications" type="button" role="tab" aria-controls="specifications" aria-selected="false">{{ __('Specifications') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="false">{{ __('Description') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">
                            {{ __('Reviews') }} ({{ $product->reviews->count() }})</button>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="specifications" role="tabpanel" aria-labelledby="specifications-tab">
                        @php
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
                        @endphp
                        @if ($hasSpecItems)
                            <div class="table-responsive mb-3">
                                <table class="table table-sm table-bordered align-middle mb-0">
                                    <tbody>
                                        @foreach($specificationItems as $item)
                                            @if(is_array($item))
                                                @php
                                                    $specLabel = trim((string) ($item['label'] ?? ''));
                                                    $specValue = trim((string) ($item['value'] ?? ''));
                                                @endphp
                                                @if($specLabel !== '' || $specValue !== '')
                                                    <tr>
                                                        <th scope="row" class="bg-light w-25">{{ $specLabel !== '' ? $specLabel : '—' }}</th>
                                                        <td>{{ $specValue !== '' ? $specValue : '—' }}</td>
                                                    </tr>
                                                @endif
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                        @if (filled($product->specification_content))
                            <div class="product-description-content product-detail-prose">
                                {!! $product->specification_content !!}
                            </div>
                        @elseif ($product->pdf_specification && ! $hasSpecItems)
                            <div class="row">
                                <div class="col-12">
                                    <embed src="{{ URL::to('uploads/products/pdf').'/'.$product->pdf_specification ?? '' }}" type="application/pdf" width="100%" height="350">
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="tab-pane fade" id="description" role="tabpanel" aria-labelledby="description-tab">
                        {!! $product->description !!}
                    </div>

                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        @if($product->reviews->count() == 0)
                            <p class="woocommerce-noreviews">{{__('There are no reviews yet.')}}</p>
                        @endif
                        <div class="star-rating">
                            <div class="rateit" data-rateit-value="{{ productRating($product->reviews) }}" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
                        </div>
                        @foreach($product->reviews as $review)
                            <b>{{ $review->user->first_name }}</b>
                            <div class="rateit" data-rateit-value="{{ $review->review_point }}" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
                            <p>{{ $review->review_note }}</p>
                            <hr>
                        @endforeach
                        @if(auth('customer')->check())
                            @if(canReview(auth('customer')->id(),$product->id))
                                <form class="contact-form ajaxform_instant_reload" action="{{ route('customer.review') }}" method="post">
                                    @csrf
                                    <div class="mb-2">
                                        <!-- Product Rating -->
                                        <input type="range" name="review_point" value="5" step="1" id="backing5" required>
                                        <div class="rateit" data-rateit-backingfld="#backing5" data-rateit-resetable="false"  data-rateit-ispreset="true" data-rateit-min="0" data-rateit-max="5">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <input type="hidden" name="product_id" value="{{$product->id}}">
                                        <div class="col-12">
                                            <div class="input-group mb-1">
                                                <textarea class="form-control" name="review_note" required></textarea>
                                                <span class="label">{{ __('Please write your experience here') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn-anime submit-btn mt-2">{{ __('Submit') }}</button>
                                </form>
                            @elseif($pendingReview)
                                <b>{{ __('Your review is pending') }}</b>
                            @else
                                <p>{{ __('You are not eligible to review this product') }}</p>
                            @endif
                        @else
                            <p>{{ __('Login to review this product') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Details End -->
    <!-- Similar Product Start -->
    <section class="similar-product pt-5">
        <div class="container">
            <div class="title-center">
                <h4>{{ __('Similar Products') }}</h4>
                <p>{{ __('The Standard chunk of lorem ipsum reproduced below those interested.') }}</p>
            </div>
            <div class="row auto-margin-3">
                @foreach($similarProducts as $similar)
                    <div class="col-sm-6 col-lg-2 col-md-4 col-6">
                        <x-frontend.product-card4 :product="$similar"></x-frontend.product-card4>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Similar Product End -->
@stop

@push('script')
    <script>
        $('.buynow-btn').on('click', function() {

            let size = $('input[name="size"]:checked').val();
            let color = $('input[name="color"]:checked').val();
            let size_id = $('input[name="size"]:checked').attr('data-size-id') || $('input[name="size"]:checked').attr('data-size_id');
            let color_id = $('input[name="color"]:checked').attr('data-color-id') || $('input[name="color"]:checked').attr('data-color_id');
            let buynow_qty = $('.input-number').val();
            let buynow_url = $(this).data('buynow-url');
            let area = $('[name="delivery_charge"]:checked').val();
            if ($('.color-variation').val()){
                if($("input[name='color']:checked").length == 0){
                    swal("{{ __('Please select a color') }}");
                    return false;
                }
            }
            if ($('.color-variation').val()){
                if($("input[name='size']:checked").length == 0){
                    swal("{{ __('Please select a size') }}");
                    return false;
                }
            }
            if($("input[name='delivery_charge']:checked").length == 0){
                swal("{{ __('Please select delivery charge') }}");
                return false;
            }

            let url = buynow_url + '&qty=' + buynow_qty + '&area=' + area + '&color_id=' + color_id + '&color=' + color + '&size_id=' + size_id + '&size=' + size;
            window.location.href = url;
        });
        $('.maan-cartbtn').on('click', function() {

            let size = $('.size-variation').val();
            let color = $('.color-variation').val();
            if (color){
                if($("input[name='color']:checked").length == 0){
                    swal("{{ __(' Please select a color') }}");
                    return false;
                }
            }
            if (size){
                if($("input[name='size']:checked").length == 0){
                    swal("{{ __(' Please select a size') }}");
                    return false;
                }
            }
            if($("input[name='delivery_charge']:checked").length == 0){
                swal("{{ __('Please select delivery charge') }}");
                return false;
            }

        });
    </script>

@endpush
