@extends('backend.layouts.app')
@section('title','Notifications - ')
@section('content')
<div class="content-body">
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="brand" role="tabpanel" aria-labelledby="brand-tab">
            <div class="container">
                <h5 class="py-2">@lang('All Notifications')</h5>
                <div class="responsibe-table">
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>@lang('#')</th>
                                <th>@lang('Message')</th>
                                <th>@lang('Created At')</th>
                                <th>@lang('Read At')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($notifications as $notify)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $notify->data['message'] ?? '' }}</td>
                                <td>{{ date('d-m-Y H:i A', strtotime($notify->created_at)) }}</td>
                                <td>{{ date('d-m-Y H:i A', strtotime($notify->read_at)) }}</td>
                                <td>
                                    <a href="{{ route('backend.notifications.mtView', $notify->data['id']) }}" class="btn btn-warning btn-sm"><i class="fas fa-eye"></i> @lang('View')</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Tab Content End -->
</div>
@endsection
