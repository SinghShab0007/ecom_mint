@extends('frontend.layouts.front')

@section('title', __('Redirecting to payment'))

@section('content')
<section class="billing-details bg-light">
    <div class="container">
        <div class="row justify-content-center py-5">
            <div class="col-lg-6 text-center">
                <div class="card shadow rounded-3">
                    <div class="card-body py-5">
                        <div id="pd-spinner" class="spinner-border mb-3" role="status" style="color:#4C1D6B;">
                            <span class="visually-hidden">{{ __('Loading...') }}</span>
                        </div>
                        <h4 id="pd-heading">{{ __('Redirecting to payment...') }}</h4>
                        <p class="text-muted">{{ __('Please wait. Do not close this page.') }}</p>
                        <p class="small text-muted mb-1">{{ __('Order') }}: {{ $order->order_no }}</p>
                        <p class="small text-muted">
                            {{ __('Amount') }}:
                            {{ currency($order->total_price + $order->shipping_cost - ($order->coupon_discount ?? 0), 2) }}
                        </p>

                        <p id="pd-error" class="text-danger small d-none mb-3"></p>

                        <a id="pd-continue" href="#" class="btn d-none"
                           style="background:#4C1D6B;color:#fff;">{{ __('Continue to payment') }}</a>
                        <button type="button" id="pd-retry" class="btn btn-outline-secondary d-none">
                            {{ __('Try again') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('script')
<script>
(function () {
    var orderId  = {{ (int) $order->id }};
    var csrf     = '{{ csrf_token() }}';
    var createUrl = '{{ route("customer.payment.paydhara.create") }}';

    var spinner  = document.getElementById('pd-spinner');
    var heading  = document.getElementById('pd-heading');
    var errorEl  = document.getElementById('pd-error');
    var continueBtn = document.getElementById('pd-continue');
    var retryBtn = document.getElementById('pd-retry');

    function showError(msg) {
        spinner.classList.add('d-none');
        heading.textContent = '{{ __("Payment could not be started") }}';
        errorEl.textContent = msg;
        errorEl.classList.remove('d-none');
        retryBtn.classList.remove('d-none');
    }

    function createPayment() {
        errorEl.classList.add('d-none');
        retryBtn.classList.add('d-none');
        continueBtn.classList.add('d-none');
        spinner.classList.remove('d-none');
        heading.textContent = '{{ __("Redirecting to payment...") }}';

        fetch(createUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ order_id: orderId })
        })
        .then(function (r) { return r.json().catch(function () { return {}; }); })
        .then(function (data) {
            if (!data || !data.success || !data.payment_link) {
                showError((data && data.message) || '{{ __("Failed to create payment.") }}');
                return;
            }
            // Surface a manual link too, in case the automatic redirect is blocked.
            continueBtn.href = data.payment_link;
            continueBtn.classList.remove('d-none');
            window.location.href = data.payment_link;
        })
        .catch(function () {
            showError('{{ __("Network error. Please try again.") }}');
        });
    }

    retryBtn.addEventListener('click', createPayment);
    createPayment();
})();
</script>
@endpush
