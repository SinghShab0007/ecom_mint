<div class="container">
    <div class="content-tab-title">
        <h4>{{__('Customer Management')}}</h4>
    </div>
    <!-- Tab Manu Start -->
    <div class="nav nav-tabs p-tab-manu" id="nav-tab" role="tablist">
        <button class="nav-link @if(Request::is('admin/customers'))active @endif" id="all-customers-tab"
                data-bs-toggle="tab"
                data-bs-target="#all-customers" type="button" role="tab" aria-controls="all-customers"
                aria-selected="false"
                @if(url()->full()!=route('backend.customers.index')) onclick="location.href='{{route('backend.customers.index')}}'" @endif
        >{{__('All Customers')}}
        </button>
        {{-- <button class="nav-link @if(Request::is('admin/customers/create'))active @endif" id="create-customers-tab"
                data-bs-toggle="tab"
                data-bs-target="#create-customers" type="button" role="tab" aria-controls="create-customers"
                aria-selected="false"
                @if(url()->full()!=route('backend.customers.create')) onclick="location.href='{{route('backend.customers.create')}}'" @endif
        >{{__('Create Customers')}}
        </button> --}}
        <button class="nav-link @if(Request::is('admin/suspended_customers'))active @endif" id="suspended-customers-tab"
                data-bs-toggle="tab"
                data-bs-target="#suspended-customers" type="button" role="tab"
                aria-controls="suspended-customers" aria-selected="false"
                @if(url()->full()!=route('backend.customers.suspended')) onclick="location.href='{{route('backend.customers.suspended')}}'" @endif
        >{{__('Suspended Customers')}}
        </button>
        <button class="nav-link @if(Request::is('admin/email_subscriber'))active @endif" id="email_subscriber-tab"
                data-bs-toggle="tab"
                data-bs-target="#email_subscriber" type="button" role="tab"
                aria-controls="email_subscriber" aria-selected="false"
                @if(url()->full()!=route('backend.email_subscriber')) onclick="location.href='{{route('backend.email_subscriber')}}'" @endif
        >{{__('Email Subscriber')}}
        </button>
    </div>
    <!-- Tab Manu End -->
</div>
