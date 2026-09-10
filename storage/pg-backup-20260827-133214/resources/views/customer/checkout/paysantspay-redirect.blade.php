@extends('frontend.layouts.front')

@section('title', __('UPI Payment'))

@section('content')
<section class="billing-details bg-light">
    <div class="container">
        <div class="row justify-content-center py-5">
            <div class="col-lg-6 text-center">
                {{-- Loading state --}}
                <div id="payment-loading" class="card shadow rounded-3">
                    <div class="card-body py-5">
                        <div class="spinner-border text-primary mb-3" role="status">
                            <span class="visually-hidden">{{ __('Loading...') }}</span>
                        </div>
                        <h4>{{ __('Redirecting to payment...') }}</h4>
                        <p class="text-muted">{{ __('Please wait. Do not close this page.') }}</p>
                        <p class="small text-muted">{{ __('Order') }}: {{ $order->order_no }}</p>
                        <p id="error-msg" class="text-danger small d-none"></p>
                        <a id="retry-btn" href="javascript:void(0)" class="btn btn-primary d-none">{{ __('Retry') }}</a>
                    </div>
                </div>

                {{-- Desktop: UPI Intent QR (expires in 15 minutes) --}}
                <div id="payment-qr" class="card shadow rounded-3 d-none">
                    <div class="card-body py-5">
                        <h4 class="mb-2">{{ __('Pay with UPI') }}</h4>
                        <p class="text-muted small mb-2">{{ __('Order') }}: {{ $order->order_no }}</p>
                        <p id="qrcode-timer" class="text-primary small mb-3">{{ __('Valid for 15 minutes') }}</p>
                        <div id="qrcode-wrap" class="mb-4">
                            <img id="qrcode-img" src="" alt="UPI QR Code" class="img-fluid mx-auto d-block" style="max-width: 240px;">
                        </div>
                        <div id="qrcode-expired" class="d-none mb-4">
                            <p class="text-danger fw-medium mb-2">{{ __('QR expired') }}</p>
                            <button type="button" id="refresh-qr-btn" class="btn btn-primary">{{ __('Get new QR') }}</button>
                        </div>
                        <p id="qrcode-valid-msg" class="text-dark fw-medium mb-1">{{ __('Scan with your phone or Paytm to pay') }}</p>
                        <p class="text-muted small">{{ __('Use any UPI app or Paytm wallet to scan and complete payment.') }}</p>
                        <a id="open-link-btn" href="#" target="_blank" rel="noopener" class="btn btn-outline-primary btn-sm mt-3 d-none">{{ __('Open payment page instead') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('script')
<script>
(function() {
    var orderId = {{ $order->id }};
    var csrf = '{{ csrf_token() }}';
    var loadingEl = document.getElementById('payment-loading');
    var qrEl = document.getElementById('payment-qr');

    function goToPayment() {
        fetch('{{ route("customer.payment.paysantspay.create") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ order_id: orderId, _token: csrf })
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (!data.success) {
                document.getElementById('error-msg').textContent = data.message || '{{ __("Failed to create payment.") }}';
                document.getElementById('error-msg').classList.remove('d-none');
                document.getElementById('retry-btn').classList.remove('d-none');
                return;
            }
            if (data.qrcode) {
                loadingEl.classList.add('d-none');
                document.getElementById('qrcode-img').src = data.qrcode;
                qrEl.classList.remove('d-none');
                document.getElementById('qrcode-wrap').classList.remove('d-none');
                document.getElementById('qrcode-expired').classList.add('d-none');
                document.getElementById('qrcode-valid-msg').classList.remove('d-none');
                document.getElementById('qrcode-timer').classList.remove('d-none');
                document.getElementById('qrcode-timer').textContent = '{{ __("Valid for 15 minutes") }}';
                var expiresAt = data.qrcode_expires_at || (Math.floor(Date.now() / 1000) + 900);
                startQrExpiryTimer(expiresAt);
                if (data.paymentLink) {
                    var linkBtn = document.getElementById('open-link-btn');
                    linkBtn.href = data.paymentLink;
                    linkBtn.classList.remove('d-none');
                }
            } else if (data.paymentLink) {
                window.location.href = data.paymentLink;
            } else {
                document.getElementById('error-msg').textContent = '{{ __("Failed to create payment.") }}';
                document.getElementById('error-msg').classList.remove('d-none');
                document.getElementById('retry-btn').classList.remove('d-none');
            }
        })
        .catch(function() {
            document.getElementById('error-msg').textContent = '{{ __("Network error. Please try again.") }}';
            document.getElementById('error-msg').classList.remove('d-none');
            document.getElementById('retry-btn').classList.remove('d-none');
        });
    }

    document.getElementById('retry-btn').addEventListener('click', function() {
        document.getElementById('error-msg').classList.add('d-none');
        this.classList.add('d-none');
        goToPayment();
    });

    var qrTimerInterval = null;

    function startQrExpiryTimer(expiresAt) {
        if (qrTimerInterval) clearInterval(qrTimerInterval);
        function tick() {
            var now = Math.floor(Date.now() / 1000);
            if (now >= expiresAt) {
                if (qrTimerInterval) clearInterval(qrTimerInterval);
                document.getElementById('qrcode-wrap').classList.add('d-none');
                document.getElementById('qrcode-valid-msg').classList.add('d-none');
                document.getElementById('qrcode-timer').classList.add('d-none');
                document.getElementById('qrcode-expired').classList.remove('d-none');
                return;
            }
            var left = expiresAt - now;
            var m = Math.floor(left / 60);
            var s = left % 60;
            document.getElementById('qrcode-timer').textContent = '{{ __("Expires in") }} ' + m + ':' + (s < 10 ? '0' : '') + s;
        }
        tick();
        qrTimerInterval = setInterval(tick, 1000);
    }

    document.getElementById('payment-qr').querySelector('#refresh-qr-btn').addEventListener('click', function() {
        document.getElementById('qrcode-expired').classList.add('d-none');
        loadingEl.classList.remove('d-none');
        qrEl.classList.add('d-none');
        goToPayment();
    });

    goToPayment();
})();
</script>
@endpush
