@extends('customer.layouts.master')

@section('title','Announcement')

@section('content')
    <!-- User Panel Content Start -->
    <div class="user-panel-content">
        <div class="announce">
            @foreach($announcements as $announcement)
                <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="post-img">
                                <img src="{{ asset('uploads/announcements') }}/{{ $announcement->thumbnail }}" alt="{{ $announcement->title }}">
                            </div>
                        </div>
                        <div class="col-xl-8">
                            <div class="post-text">
                                <h5>{{ $announcement->title }}</h5>
                                <p>{{ $announcement->description }}</p>
                                <div class="post-btns">
                                    <button class="btn btn-warning">{{ __('BUY NOW') }}</button>
                                    <span><strike>{{ currency($announcement->old_price) }}</strike></span>
                                    <span>{{ currency($announcement->sale_price) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <!-- User Panel Content End -->
@stop
