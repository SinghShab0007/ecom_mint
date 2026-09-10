<div class="container">
    <div class="content-tab-title">
        <h4>{{__('Wallet')}}</h4>
    </div>
    <!-- Tab Manu Start -->
    <div class="nav nav-tabs p-tab-manu" id="nav-tab" role="tablist">
        <button class="nav-link @if(Request::is('seller/earning'))active @endif" id="stock-report-tab" data-bs-toggle="tab" data-bs-target="#stock-report" type="button"
                role="tab" aria-controls="stock-report" aria-selected="false"
                @if(url()->full()!=route('seller.earning')) onclick="location.href='{{route('seller.earning')}}'" @endif
        >{{__('Earning')}}
        </button>
        <button class="nav-link @if(Request::is('seller/withdraw_earning'))active @endif" id="customer-report-tab" data-bs-toggle="tab" data-bs-target="#customer-report"
                type="button" role="tab" aria-controls="customer-report" aria-selected="false"
                @if(url()->full()!=route('seller.withdraw_earning')) onclick="location.href='{{route('seller.withdraw_earning')}}'" @endif
        >{{__('Withdraw')}}
        </button>
    </div>
    <!-- Tab Manu End -->
</div>