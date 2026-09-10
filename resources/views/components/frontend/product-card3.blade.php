<div class="product-card product-shop-list-items">
    <div class="product-img">
        <a href="{{ route('product',$product->slug) }}">

            <span class="offer-percent">20% OFF</span>
            @if($product->images->first()->image ?? false)
            <img src="{{ asset('uploads/products/galleries/'.$product->images->first()->image ?? '') }}" class="b-1" alt="{{ $product->name }}" >
            @endif

            @if ($product->quantity <= 0 && $product->is_manage_stock)
                <small class="sold-out">Sold out</small>
            @endif
        </a>
        @isset($product->details->flash_deal_title)
            @if($product->details->flash_deal_title == '')
                <span></span>
            @else
                <span class="tag">{{ $product->details->flash_deal_title }}</span>
            @endif
        @endisset
        @if($product->quantity <= 0 && $product->is_manage_stock)
            <div class="stock-out">
                <p>Stock Out</p>
            </div>
        @endif
    </div>
    <div class="product-card-details">
        <div class="star-rating">
            <div class="rateit" data-rateit-value="{{ productRating($product->reviews) }}" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
        </div>
        <h5 class="title"><a href="{{ route('product',$product->slug) }}">{{ $product->name }}</a></h5>
        @if(hasPromotion($product->id))
            <span class="price">{{ currency($product->unit_price,2) }}</span>
        @else
            @if($product->discount > 0)
                <span class="price">{{ currency($product->unit_price,2) }}</span>
            @else
                <span class="price">{{ currency($product->unit_price,2) }}</span>
            @endif
        @endif
        <p>{{ substr(strip_tags($product->description),0,260) }}</p>
        <ul class="product-cart">
            <li>
                <a href="javascript:addToWishlist({{ $product->id }})"><span class="icon"><svg viewBox="0 -28 512.001 512" xmlns="http://www.w3.org/2000/svg"><path d="m256 455.515625c-7.289062 0-14.316406-2.640625-19.792969-7.4375-20.683593-18.085937-40.625-35.082031-58.21875-50.074219l-.089843-.078125c-51.582032-43.957031-96.125-81.917969-127.117188-119.3125-34.644531-41.804687-50.78125-81.441406-50.78125-124.742187 0-42.070313 14.425781-80.882813 40.617188-109.292969 26.503906-28.746094 62.871093-44.578125 102.414062-44.578125 29.554688 0 56.621094 9.34375 80.445312 27.769531 12.023438 9.300781 22.921876 20.683594 32.523438 33.960938 9.605469-13.277344 20.5-24.660157 32.527344-33.960938 23.824218-18.425781 50.890625-27.769531 80.445312-27.769531 39.539063 0 75.910156 15.832031 102.414063 44.578125 26.191406 28.410156 40.613281 67.222656 40.613281 109.292969 0 43.300781-16.132812 82.9375-50.777344 124.738281-30.992187 37.398437-75.53125 75.355469-127.105468 119.308594-17.625 15.015625-37.597657 32.039062-58.328126 50.167969-5.472656 4.789062-12.503906 7.429687-19.789062 7.429687zm-112.96875-425.523437c-31.066406 0-59.605469 12.398437-80.367188 34.914062-21.070312 22.855469-32.675781 54.449219-32.675781 88.964844 0 36.417968 13.535157 68.988281 43.882813 105.605468 29.332031 35.394532 72.960937 72.574219 123.476562 115.625l.09375.078126c17.660156 15.050781 37.679688 32.113281 58.515625 50.332031 20.960938-18.253907 41.011719-35.34375 58.707031-50.417969 50.511719-43.050781 94.136719-80.222656 123.46875-115.617188 30.34375-36.617187 43.878907-69.1875 43.878907-105.605468 0-34.515625-11.605469-66.109375-32.675781-88.964844-20.757813-22.515625-49.300782-34.914062-80.363282-34.914062-22.757812 0-43.652344 7.234374-62.101562 21.5-16.441406 12.71875-27.894532 28.796874-34.609375 40.046874-3.453125 5.785157-9.53125 9.238282-16.261719 9.238282s-12.808594-3.453125-16.261719-9.238282c-6.710937-11.25-18.164062-27.328124-34.609375-40.046874-18.449218-14.265626-39.34375-21.5-62.097656-21.5zm0 0"></path></svg></span></a>
            </li>
            <li>
                <a href="javascript:addToCart({{ $product->id }})">
                    <span class="icon">
                    <svg id="shopping-cart" xmlns="http://www.w3.org/2000/svg" width="16.155" height="14.198" viewBox="0 0 16.155 14.198">
                        <path id="Path_4229" data-name="Path 4229" d="M5.238,9.466h8.551a.472.472,0,0,0,.455-.343L16.136,2.5a.473.473,0,0,0-.455-.6H4.145L3.807.371A.473.473,0,0,0,3.344,0H.473a.473.473,0,1,0,0,.947H2.965L4.674,8.637a1.419,1.419,0,0,0,.564,2.721h8.551a.473.473,0,1,0,0-.947H5.238a.473.473,0,1,1,0-.947Zm0,0" transform="translate(0 0)" fill="#fff"/>
                        <path id="Path_4230" data-name="Path 4230" d="M151,361.424a1.42,1.42,0,1,0,1.42-1.42A1.421,1.421,0,0,0,151,361.424Zm0,0" transform="translate(-146.236 -348.645)" fill="#fff"/>
                        <path id="Path_4231" data-name="Path 4231" d="M362,361.424a1.42,1.42,0,1,0,1.42-1.42A1.421,1.421,0,0,0,362,361.424Zm0,0" transform="translate(-350.582 -348.645)" fill="#fff"/>
                        </svg>
                    </span>
                </a>
            </li>
        </ul>
    </div>
</div>
