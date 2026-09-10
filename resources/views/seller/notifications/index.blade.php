@extends('layouts.seller')

@section('title','Brands - ')

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
                            @foreach(auth('seller')->user()->notifications as $notification)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $notification->data['message'] ?? '' }}</td>
                                    <td>{{ date('d-m-Y H:i A', strtotime($notification->created_at)) }}</td>
                                    <td>{{ date('d-m-Y H:i A', strtotime($notification->read_at)) }}</td>
                                    <td>
                                        <a href="{{ route('seller.notifications.mtView', $notification->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-eye"></i> @lang('View')</a>
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
