<div class="content-tab-title">
    <h4>{{__('Variation')}}</h4>
</div>
<!-- Tab Manu Start  -->
<div class="nav nav-tabs p-tab-manu" id="nav-tab" role="tablist">
    <button class="nav-link @if(Request::is('admin/colors'))active @endif" id="header-tab" data-bs-toggle="tab" data-bs-target="#header"
            type="button" role="tab" aria-controls="header" aria-selected="true"
            @if(url()->full()!=route('backend.colors.index')) onclick="location.href='{{route('backend.colors.index')}}'" @endif
    >{{__('Color')}}
    </button>
    <button class="nav-link @if(Request::is('admin/colors/create'))active @endif" id="pages-tab" data-bs-toggle="tab" data-bs-target="#pages" type="button"
            role="tab" aria-controls="pages" aria-selected="false"
            @if(url()->full()!=route('backend.colors.create')) onclick="location.href='{{route('backend.colors.create')}}'" @endif
    >{{__('Add Color')}}
    </button>
    <button class="nav-link @if(Request::is('admin/sizes'))active @endif" id="appearance-tab" data-bs-toggle="tab" data-bs-target="#appearance"
            type="button" role="tab" aria-controls="appearance" aria-selected="false"
            @if(url()->full()!=route('backend.sizes.index')) onclick="location.href='{{route('backend.sizes.index')}}'" @endif
    >{{__('Size')}}
    </button>
    <button class="nav-link @if(Request::is('admin/sizes/create'))active @endif" id="appearance-tab" data-bs-toggle="tab" data-bs-target="#appearance"
            type="button" role="tab" aria-controls="appearance" aria-selected="false"
            @if(url()->full()!=route('backend.sizes.create')) onclick="location.href='{{route('backend.sizes.create')}}'" @endif
    >{{__('Add Size')}}
    </button>

</div>