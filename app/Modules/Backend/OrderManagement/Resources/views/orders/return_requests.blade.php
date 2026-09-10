@extends('backend.layouts.app')
@section('title','Return Requests - ')
@push('css')
    @include('backend.includes.datatable_css')
@endpush
@section('content')
    <div class="content-body">
        @include('ordermanagement::orders.order_overview')

        <div class="tab-content order-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="returns" role="tabpanel">
                <div class="container">
                    <div class="content-table">
                        <h5 class="mb-3">{{ __('Return Requests') }}</h5>
                        <p class="text-muted small">
                            {{ __('Approving restores the stock and reverses the seller commission. Refunds are handled manually.') }}
                        </p>
                        <table id="mDataTable" class="table p-table">
                            <thead>
                            <tr>
                                <th scope="col">{{ __('Invoice#') }}</th>
                                <th scope="col">{{ __('Customer') }}</th>
                                <th scope="col">{{ __('Product') }}</th>
                                <th scope="col">{{ __('Qty') }}</th>
                                <th scope="col">{{ __('Payment') }}</th>
                                <th scope="col">{{ __('Reason') }}</th>
                                <th scope="col">{{ __('Status') }}</th>
                                <th scope="col">{{ __('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    @include('backend.includes.datatable_js')
    <script>
        $(function () {
            "use strict";
            var table = $('#mDataTable').DataTable({
                ajax: "{{ route('backend.return_requests.list') }}",
                columns: [
                    { data: 'order_no' },
                    { data: 'customer' },
                    { data: 'product' },
                    { data: 'qty' },
                    { data: 'payment' },
                    { data: 'reason' },
                    { data: 'status' },
                    { data: 'action', searchable: false, sortable: false }
                ]
            });

            function post(url, payload, okMsg) {
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: $.extend({ _token: "{{ csrf_token() }}" }, payload)
                }).done(function (res) {
                    swal("{{ __('Done') }}", (res && res.message) ? res.message : okMsg, "success");
                    table.ajax.reload(null, false);
                }).fail(function (xhr) {
                    var msg = (xhr.responseJSON && xhr.responseJSON.message)
                        ? xhr.responseJSON.message : "{{ __('Something went wrong.') }}";
                    swal("{{ __('Sorry!') }}", msg, "error");
                });
            }

            $('#mDataTable').on('click', '.approve-return', function () {
                var id = $(this).data('id');
                swal({
                    title: "{{ __('Approve this return?') }}",
                    text: "{{ __('Stock will be restored and the seller commission reversed.') }}",
                    icon: "warning", buttons: true
                }).then(function (ok) {
                    if (ok) { post("{{ route('backend.return.approve') }}", { detail_id: id }, "{{ __('Approved.') }}"); }
                });
            });

            $('#mDataTable').on('click', '.reject-return', function () {
                var id = $(this).data('id');
                swal({
                    title: "{{ __('Reject this return?') }}",
                    text: "{{ __('Optionally add a reason:') }}",
                    icon: "warning",
                    content: "input",
                    buttons: true
                }).then(function (reason) {
                    if (reason === null) { return; }
                    post("{{ route('backend.return.reject') }}", { detail_id: id, reason: reason || '' }, "{{ __('Rejected.') }}");
                });
            });
        });
    </script>
@endpush
