@extends('backend.layouts.app')
@section('title','Customer Show - ')
@section('content')
    <div class="content-body">
        <div class="container">
            <div class="content-title">{{__('Customer Information')}}</div>
            <div class="form-group row">
                <label class="col-lg-4">{{__('Name')}}</label>
                <div class="col-lg-8">{{$customer->full_name()}} </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-4">{{__('Email')}}</label>
                <div class="col-lg-8">{{$customer->email}} </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-4">{{__('Mobile')}}</label>
                <div class="col-lg-8">{{$customer->mobile}} </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-4">{{__('Address')}}</label>
                <div class="col-lg-8">{{$customer->adress}} </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-4">{{__('Gender')}}</label>
                <div class="col-lg-8">@if($customer->user_gender==1) Male @elseif($customer->user_gender==2) Female @else Other @endif </div>
            </div>
        </div>
    </div>
@endsection
