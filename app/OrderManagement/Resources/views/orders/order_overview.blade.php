<div class="container order-manu">
    <div class="content-tab-title">
        <h4>{{__('Overview of environment')}}</h4>
    </div>

    <!-- Tab Manu Start -->
    <div class="nav nav-tabs mb-4" id="nav-tab" role="tablist">
        <div class="maan-counter-box @if(Request::is('admin/orders','seller/orders'))active @endif" data-bs-toggle="tab"
             data-bs-target="#order-list"
             @if(url()->full()!=route('backend.orders.index') && url()->full()!=route('seller.orders.index')) onclick="location.href='@auth('admin'){{route('backend.orders.index')}}@elseauth('seller'){{route('seller.orders.index')}}@endauth'" @endif
        >
            <div class="maan-icon maan-radius maan-icon-clr-lightdanger">
                <i> <img src="{{URL::to('backend/img/icons/1.svg')}}" alt="Icon"></i>
            </div>
            <div class="maan-desc">
                <div class="maan-counter">
                    <span class="maan-counter-title counter">{{$order_overview['total_order']??0}}</span>
                </div>
                <p class="maan-counter-content">{{__('Total Order')}}</p>
            </div>
        </div>
        <div class="maan-counter-box  @if(Request::is('admin/pending_orders','seller/pending_orders'))active @endif"
             data-bs-toggle="tab" data-bs-target="#pending"
             @if(url()->full()!=route('backend.pending_orders')&&url()->full()!=route('seller.pending_orders')) onclick="location.href='@auth('admin'){{route('backend.pending_orders')}}@elseauth('seller'){{route('seller.pending_orders')}}@endauth'" @endif
        >
            <div class="maan-icon maan-radius maan-icon-clr-lightblue">
                <i> <img src="{{URL::to('backend/img/icons/pending-blue.svg')}}" alt="Icon"></i>
            </div>
            <div class="maan-desc">
                <div class="maan-counter">
                    <div class="maan-counter">
                        <span class="maan-counter-title counter">{{ $order_overview[1]??0}}</span>
                    </div>
                    <p class="maan-counter-content">{{__('Pending Order')}}</p>
                </div>
            </div>
        </div>
        <div class="maan-counter-box @if(Request::is('admin/confirmed_orders','seller/confirmed_orders'))active @endif"
             data-bs-toggle="tab" data-bs-target="#confirmed"
             @if(url()->full()!=route('backend.confirmed_orders') && url()->full()!=route('seller.confirmed_orders')) onclick="location.href='@auth('admin'){{route('backend.confirmed_orders')}}@elseauth('seller'){{route('seller.confirmed_orders')}}@endauth'" @endif>
            <div class="maan-icon maan-radius maan-icon-clr-lightgreen">
                <i> <img src="{{URL::to('backend/img/icons/Confirmed-green.svg')}}" alt="Icon"></i>
            </div>
            <div class="maan-desc">
                <div class="maan-counter">
                    <span class="maan-counter-title counter">{{ $order_overview[2]??0}}</span>
                </div>
                <p class="maan-counter-content">{{__('Order Confirmed')}}</p>
            </div>
        </div>
        <div class="maan-counter-box @if(Request::is('admin/processing_orders','seller/processing_orders'))active @endif"
            data-bs-toggle="tab" data-bs-target="#processing"
            @if(url()->full()!=route('backend.processing_orders') && url()->full()!=route('seller.processing_orders')) onclick="location.href='@auth('admin'){{route('backend.processing_orders')}}@elseauth('seller'){{route('seller.processing_orders')}}@endauth'" @endif>
            <div class="maan-icon maan-radius maan-icon-clr-lightyellow">
                <i> <img src="{{URL::to('backend/img/icons/Processing.svg')}}" alt="Icon"></i>
            </div>
            <div class="maan-desc">
                <div class="maan-counter">
                    <span class="maan-counter-title counter">{{ $order_overview[3]??0}}</span>
                </div>
                <p class="maan-counter-content">{{__('Order Processing')}}</p>
            </div>
        </div>
        <div class="maan-counter-box @if(Request::is('admin/picked_orders','seller/picked_orders'))active @endif"
             data-bs-toggle="tab" data-bs-target="#picked"
             @if(url()->full()!=route('backend.processing_orders') && url()->full()!=route('seller.processing_orders')) onclick="location.href='@auth('admin'){{route('backend.processing_orders')}}@elseauth('seller'){{route('seller.processing_orders')}}@endauth'" @endif
        >
            <div class="maan-icon maan-radius maan-icon-clr-lightyellow">
                <i> <img src="{{URL::to('backend/img/icons/pick.svg')}}" alt="Icon"></i>
            </div>
            <div class="maan-desc">
                <div class="maan-counter">
                    <span class="maan-counter-title counter">{{ $order_overview[4]??0}}</span>
                </div>
                <p class="maan-counter-content">{{__('Order Picked')}}</p>
            </div>
        </div>
        <div class="maan-counter-box @if(Request::is('admin/shipped_orders','seller/shipped_orders'))active @endif"
             data-bs-toggle="tab" data-bs-target="#shipped"
             @if(url()->full()!=route('backend.shipped_orders') && url()->full()!=route('seller.shipped_orders')) onclick="location.href='@auth('admin'){{route('backend.shipped_orders')}}@elseauth('seller'){{route('seller.shipped_orders')}}@endauth'" @endif>
            <div class="maan-icon maan-radius maan-icon-clr-lightgreen1">
                <i> <img src="{{URL::to('backend/img/icons/shipping.svg')}}" alt="Icon"></i>
            </div>
            <div class="maan-desc">
                <div class="maan-counter">
                    <span class="maan-counter-title counter">{{ $order_overview[5]??0}}</span>
                </div>
                <p class="maan-counter-content">{{__('Order Shipped')}}</p>
            </div>
        </div>
        <div class="maan-counter-box @if(Request::is('admin/delivered_orders','seller/delivered_orders'))active @endif"
             data-bs-toggle="tab" data-bs-target="#delivered"
             @if(url()->full()!=route('backend.delivered_orders') && url()->full()!=route('seller.delivered_orders')) onclick="location.href='@auth('admin'){{route('backend.delivered_orders')}}@elseauth('seller'){{route('seller.delivered_orders')}}@endauth'" @endif>
            <div class="maan-icon maan-radius maan-icon-clr-lightblue1">
                <i> <img src="{{URL::to('backend/img/icons/Delivered.svg')}}" alt="Icon"></i>
            </div>
            <div class="maan-desc">
                <div class="maan-counter">
                    <span class="maan-counter-title counter">{{ $order_overview[6]??0}}</span>
                </div>
                <p class="maan-counter-content">{{__('Order Delivered')}}</p>
            </div>
        </div>
        <div class="maan-counter-box @if(Request::is('admin/cancelled_orders','seller/cancelled_orders'))active @endif"
             data-bs-toggle="tab" data-bs-target="#canclled"
             @if(url()->full()!=route('backend.cancelled_orders') && url()->full()!=route('seller.cancelled_orders')) onclick="location.href='@auth('admin'){{route('backend.cancelled_orders')}}@elseauth('seller'){{route('seller.cancelled_orders')}}@endauth'" @endif>
            <div class="maan-icon maan-radius maan-icon-clr-lightred">
                <i> <img src="{{URL::to('backend/img/icons/order-cancel.svg')}}" alt="Icon"></i>
            </div>
            <div class="maan-desc">
                <div class="maan-counter">
                    <span class="maan-counter-title counter">{{ $order_overview[7]??0}}</span>
                </div>
                <p class="maan-counter-content">{{__('Order Canceled')}}</p>
            </div>
        </div>
    </div>
    <!-- Tab Manu End -->
</div>
