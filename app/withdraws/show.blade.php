@extends('backend.layouts.app')
@section('title','Withdraws View')

@section('content')
    <div class="content-body">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between">
                        <h5><a class="btn btn-sm btn-primary text-light rounded-pill" href="{{ route('backend.withdraws.index') }}"> <i class="fa fa-backward" aria-hidden="true"></i> {{ __('Back') }}</a> {{ __('Withdraw view') }}</h4>
                        <div>
                            @if ($withdraw->status != 'approved')
                            <a class="action-confirm btn btn-success text-light" data-type="GET" data-action="{{ route('backend.withdraws.approved', ['withdraw' => $withdraw->id]) }}" data-content="You want to approve this withdraw?" data-icon="success">
                                <i class="fa fa-check" aria-hidden="true"></i>
                                {{ __('Approve') }}
                            </a>
                            @endif
                            @if ($withdraw->status != 'rejected')
                            <a class="action-confirm btn btn-danger text-light" data-type="GET" data-action="{{ route('backend.withdraws.reject', ['withdraw' => $withdraw->id]) }}" data-content="You want to reject this withdraw?" data-icon="warning">
                                <i class="fa fa-ban" aria-hidden="true"></i>
                                {{ __('Reject') }}
                            </a>
                            @endif
                        </div>
                    </div>
                    <div class="table-responsive mt-4">
                        <table class="table table-striped table-bordered table-hover">
                            <tr>
                                <th><b>{{ __('Amount') }}</b></th>
                                <td>{{ currency($withdraw->amount,2) }}</td>
                                <th><b>{{ __('Created At') }}</b></th>
                                <td>{{ date("d M Y", strtotime($withdraw->created_at)) . ' at ' . date("h:i A", strtotime($withdraw->created_at)) }}</td>
                            </tr>
                            <tr>
                                <th><b>{{ __('Trx Id') }}</b></th>
                                <td>{{ $withdraw->trx_id }}</td>
                                <th><b>{{ __('Seller') }}</b></th>
                                <td>{{ $withdraw->seller->first_name .' '. $withdraw->seller->last_name }}</td>
                            </tr>
                            <tr>
                                <th><b>{{ __('Status') }}</b></th>
                                <td>
                                    @if ($withdraw->status == 'pending')
                                        <span class="badge bg-warning">{{ __('Pending') }}</span>
                                    @elseif ($withdraw->status == 'rejected')
                                        <span class="badge bg-danger">{{ __('Rejected') }}</span>
                                    @elseif ($withdraw->status == 'approved')
                                        <span class="badge bg-success">{{ __('Approved') }}</span>
                                    @endif
                                </td>
                                <th><b>{{ __('Bank name') }}</b></th>
                                <td>{{ $withdraw->bank_name }}</td>
                            </tr>
                            <tr>
                                <th><b>{{ __('Bank branch') }}</b></th>
                                <td>{{ $withdraw->bank_name }}</td>
                                <th><b>{{ __('Account holder') }}</b></th>
                                <td>{{ $withdraw->account_holder }}</td>
                            </tr>
                            <tr>
                                <th><b>{{ __('Account') }}</b></th>
                                <td>{{ $withdraw->account }}</td>
                                <th><b>{{ __('Account Type') }}</b></th>
                                <td>{{ $withdraw->account_type }}</td>
                            </tr>
                            <tr>
                                <th><b>{{ __('Routing number') }}</b></th>
                                <td>{{ $withdraw->routing_number }}</td>
                                <th><b>{{ __('Swift code') }}</b></th>
                                <td>{{ $withdraw->swift_code }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
