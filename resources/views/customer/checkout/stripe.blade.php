@extends('frontend.layouts.front')

@section('content')

    <!-- Breadcrumb Start -->
    <nav class="breadcrumb-manu" aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ url('shop') }}">{{ __('Shop') }}</a></li>
            </ol>
        </div>
    </nav>
    <!-- Breadcrumb End -->

    <!-- Login Form Start -->
    <section class="login">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-lg-6">
                    <div class="login-form">
                        <h4>{{ __('Payment Details') }}</h4>
                        <form action="{{ route('customer.stripe') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-group payment-option">
                                        <ul>
                                            <li><img src="{{ asset('uploads/1.png') }}" alt="credit-card"></li>
                                            <li><img src="{{ asset('uploads/3.png') }}" alt="credit-card"></li>
                                            <li><img src="{{ asset('uploads/5.png') }}" alt="credit-card"></li>
                                            <li><img src="{{ asset('uploads/7.png') }}" alt="credit-card"></li>
                                            <li><img src="{{ asset('uploads/8.png') }}" alt="credit-card"></li>
                                            <li><img src="{{ asset('uploads/9.png') }}" alt="credit-card"></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group">
                                        <input type="text" name="name" required>
                                        <span class="label">{{ __('Full name') }}</span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group">
                                        <input type="text" name="card_number" maxlength="16" required>
                                        <span class="label">{{ __('Card Number') }}</span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <select name="month" id="month" class="form-control" required>
                                            <option value="">{{ __('-- Select Month --') }}</option>
                                            <option value="1">{{ __('January') }}</option>
                                            <option value="2">{{ __('February') }}</option>
                                            <option value="3">{{ __('March') }}</option>
                                            <option value="4">{{ __('April') }}</option>
                                            <option value="5">{{ __('May') }}</option>
                                            <option value="6">{{ __('June') }}</option>
                                            <option value="7">{{ __('July') }}</option>
                                            <option value="8">{{ __('August') }}</option>
                                            <option value="9">{{ __('September') }}</option>
                                            <option value="10">{{ __('October') }}</option>
                                            <option value="11">{{ __('November') }}</option>
                                            <option value="12">{{ __('December') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <select name="year" id="year" class="form-control" required>
                                            <option value="">{{ __('-- Select Year --') }}</option>
                                            <option value="2021">{{ __('2021') }}</option>
                                            <option value="2022">{{ __('2022') }}</option>
                                            <option value="2023">{{ __('2023') }}</option>
                                            <option value="2024">{{ __('2024') }}</option>
                                            <option value="2025">{{ __('2025') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <input type="text" name="cvc" required>
                                        <span class="label">{{ __('CCV') }}</span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn-anime">{{ __('Confirm Payment') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@stop
