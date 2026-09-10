<div class="container">
    <div class="content-tab-title">
        <h4>{{__('Seller Management')}}</h4>
    </div>
    <!-- Tab Manu Start -->
    <div class="nav nav-tabs p-tab-manu" id="nav-tab" role="tablist">
        <button class="nav-link @if(Request::is('admin/sellers/create')) active @endif" id="create-seller-tab"
                data-bs-toggle="tab" data-bs-target="#create-seller"
                type="button" role="tab" aria-controls="create-seller" aria-selected="false"
                @if(url()->full()!=route('backend.sellers.create')) onclick="location.href='{{route('backend.sellers.create')}}'" @endif
        >{{__('Create Seller')}}
        </button>
        <button class="nav-link  @if(Request::is('admin/sellers')) active @endif" id="seller-list-tab" data-bs-toggle="tab"
                data-bs-target="#seller-list"
                type="button" role="tab" aria-controls="seller-list" aria-selected="false"
                @if(url()->full()!=route('backend.sellers.index')) onclick="location.href='{{route('backend.sellers.index')}}'" @endif
        >{{__('Seller list')}}
        </button>
    </div>
    <!-- Tab Manu End -->
</div>
