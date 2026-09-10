<h6>{{ $title }}</h6>
<div class="widget-popular">
    <ul>
        @foreach($products as $product)
            <li>
                @if($product->images->first()->image ?? false)
                <div class="pro-img">
                    <img src="{{ asset('uploads/products/galleries/'.$product->images->first()->image ?? '') }}" alt="{{ $product->name }}" >
                </div>
                @endif
                <div class="pro-text">
                    <h6><a href="{{ route('product',$product->slug) }}">{{ $product->name }}</a></h6>
                    <div class="star-rating">
                        <div class="rateit" data-rateit-value="{{ productRating($product->reviews) }}" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
                    </div>
                    @if(hasPromotion($product->id))
                        <p>{{ currency(promotionPrice($product->id),2) }} <br><del class="text-secondary">{{ currency($product->unit_price,2) }}</del></p>
                    @else
                        @if($product->discount > 0)
                            <p>{{ currency(($product->unit_price - $product->discount),2) }} <br><del class="text-secondary">{{ currency($product->unit_price,2) }}</del></p>
                        @else
                            <p>{{ currency($product->unit_price,2) }}</p>
                        @endif
                    @endif
                </div>
            </li>
        @endforeach
    </ul>
</div>
