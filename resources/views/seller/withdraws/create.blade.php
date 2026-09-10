@extends('layouts.seller')
@section('title', __('Withdraw Earning'))
@push('css')
    @include('backend.includes.datatable_css')
@endpush
@section('content')
    <div class="content-body">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('seller.withdraws.store') }}" method="POST" class="ajaxform_instant_reload">
                        @csrf
                        <div class="row mb-3">
                            <div class="d-flex flex-wrap justify-content-between">
                                <h4 class="title">{{ __('Make withdraw') }}</h4>
                                <a class="btn btn-warning" href=""><b> <i class="fa-solid fa-list"></i> {{ __('View List') }}</b></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 my-2">
                                <label for="bank_name">{{ __('Amount') }}</label>
                                <input name="amount" id="amount" type="number" class="form-control" placeholder="Amount" required>
                            </div>
                            <div class="col-md-6 my-2">
                                <label for="bank_name">{{ __('Bank Name') }}</label>
                                <input name="bank_name" id="bank_name" type="text" class="form-control" placeholder="Bank Name" required>
                            </div>
                            <div class="col-md-6 my-2">
                                <label for="bank_branch">{{ __('Branch Name') }}</label>
                                <input name="bank_branch" id="bank_branch" type="text" class="form-control" placeholder="Branch Name" required>
                            </div>
                            <div class="col-md-6 my-2">
                                <label for="account_holder">{{ __('Account holder name') }}</label>
                                <input name="account_holder" id="account_holder" type="text" class="form-control" placeholder="Account holder name" required>
                            </div>
                            <div class="col-md-6 my-2">
                                <label for="account">{{ __('Account number') }}</label>
                                <input name="account" id="account" type="number" class="form-control" placeholder="Account number" required>
                            </div>
                            <div class="col-md-6 my-2">
                                <label for="routing_number">{{ __('Routing Number') }}</label>
                                <input name="routing_number" id="routing_number" type="number" class="form-control" placeholder="Routing Number">
                            </div>
                            <div class="col-md-6 my-2">
                                <label for="account_type">{{ __('Account type') }}</label>
                                <select name="account_type" id="account_type" class="form-control form-select">
                                    <option value="">-{{ __('Select') }}</option>
                                    <option value="Checking">{{ __('Checking') }}</option>
                                    <option value="Savings">{{ __('Savings') }}</option>
                                    <option value="Current">{{ __('Current') }}</option>
                                </select>
                            </div>
                            <div class="col-md-6 my-2">
                                <label for="swift_code">{{ __('Account Swift code') }}</label>
                                <input name="swift_code" id="swift_code" type="text" class="form-control" placeholder="Account Swift code">
                            </div>
                            <div class="col-md-6 my-2">
                                <label for="note">{{ __('Note') }}</label>
                                <textarea name="note" id="note" cols="30" rows="3" class="form-control" required></textarea>
                            </div>
                            <div class="col-md-6 my-2">
                                <label for="password">{{ __('Password') }}</label>
                                <input name="password" id="password" type="password" class="form-control" placeholder="Enter your password" required>
                            </div>
                            <div class="col-lg-12 my-2 text-end">
                                <div class="button-wrapper">
                                    <button type="submit" class="btn theme-btn submit-btn"><i class="fa-solid fa-floppy-disk"></i> {{ __('Submit') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection