<div class="content-tab-title">
    <h4>{{__('Addon Management')}}</h4>
</div>
<!-- Tab Manu Start -->
<div class="nav nav-tabs p-tab-manu" id="nav-tab" role="tablist">
    <button class="nav-link @if(Request::is('admin/addons/installed_addon')) active @endif" id="installed-addon-tab"
            data-bs-toggle="tab" data-bs-target="#installed-addon"
            type="button" role="tab" aria-controls="installed-addon" aria-selected="true"
            @if(url()->full()!=route('backend.addons.installed_addon')) onclick="location.href='{{route('backend.addons.installed_addon')}}'" @endif
    >{{__('Installed Addon')}}
    </button>
    <button class="nav-link @if(Request::is('admin/addons/available_products')) active @endif" id="available-product-tab"
            data-bs-toggle="tab" data-bs-target="#available-product"
            type="button" role="tab" aria-controls="available-product" aria-selected="true"
            @if(url()->full()!=route('backend.addons.available_products')) onclick="location.href='{{route('backend.addons.available_products')}}'" @endif
    >{{__('Available Product')}}
    </button>
</div>