@extends('layouts.seller')

@section('title','Financial Statement')

@push('css')
    @include('backend.includes.datatable_css')
@endpush

@section('content')

    <!-- Content Body Start -->
    <div class="content-body">
        <div class="container">
            <div class="profile-section-wrapper">
                <div class="profile-title">
                    <h3>{{ __('Account Statement') }}</h3>
                </div>
                <div class="account-starement-subtitle">
                    <form action="{{ route('seller.finance.statement') }}">
                        <div class="left-side">
                            <label>{{ __('Period') }}</label>
                            <select name="month" id="">
                                <option value="january">January</option>
                                <option value="february">February</option>
                                <option value="march">March</option>
                                <option value="april">April</option>
                                <option value="map">May</option>
                                <option value="june">June</option>
                                <option value="july">July</option>
                                <option value="august">August</option>
                                <option value="september">September</option>
                                <option value="october">October</option>
                                <option value="november">November</option>
                                <option value="december">December</option>
                            </select>
                            <select name="year" id="">
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                            </select>
                            <button type="submit" class="btn btn-default">
                                <i class="fa-solid fa-magnifying-glass-dollar"></i>
                            </button>
                        </div>
                    </form>
                    <div class="right-side">
                        <a href="#" onclick="window.print()" class="btn border-white-btn">Print</a>
                        <a href="" class="btn border-white-btn">Export</a>
                        <a href="" class="btn border-white-btn">View Export History</a>
                    </div>
                </div>
                <div class="statement-invoice">
                    <div class="paid-status unpaid">
                        <span>Not Paid</span>
                    </div>
                    <div class="invoice-status">
                        <h6 class="invoice-title">Opening Balance</h6>
                        <p>Unpaid balance from previous statements <span>0.00 BDT</span></p>
                    </div>
                    <div class="statement-content">
                        <span class="invoice-comment">Orders</span>
                        <div class="invoice-content">
                            <p class="item">
                                <span class="item-desc-comment">Item Charges</span>
                                <span class="item-count">{{ number_format($orders->sum('total_price'),2) }} BDT</span>
                            </p>
                            <p class="item">
                                <span class="item-desc-comment">Claims</span>
                                <span class="item-count">0.00 BDT</span>
                            </p>
                            <p class="item">
                                <span class="item-desc-comment">Other Credit</span>
                                <span class="item-count">0.00 BDT</span>
                            </p>
                            <p class="item">
                                <span class="item-desc-comment">Mybazar Fees</span>
                                <span class="item-count">0.00 BDT</span>
                            </p>
                            <p class="item">
                                <span class="item-desc-comment">Penalties</span>
                                <span class="item-count">0.00 BDT</span>
                            </p>
                            <p class="item">
                                <span class="item-desc-comment">Other Debit</span>
                                <span class="item-count">0.00 BDT</span>
                            </p>
                            <p class="item">
                                <span class="item-desc-comment">VAT</span>
                                <span class="item-count">0.00 BDT</span>
                            </p>
                            <div class="subtotal">
                                <span class="item-desc-comment">Subtotal</span>
                                <span class="item-count">0.00 BDT</span>
                            </div>
                        </div>
                    </div>
                    <div class="statement-content">
                        <span class="invoice-comment">Refunds</span>
                        <div class="invoice-content">
                            <p class="item">
                                <span class="item-desc-comment">Item Charges</span>
                                <span class="item-count">0.00 BDT</span>
                            </p>
                            <p class="item">
                                <span class="item-desc-comment">Claims</span>
                                <span class="item-count">0.00 BDT</span>
                            </p>
                            <p class="item">
                                <span class="item-desc-comment">Other Credit</span>
                                <span class="item-count">0.00 BDT</span>
                            </p>
                            <p class="item">
                                <span class="item-desc-comment">Mybazar Fees</span>
                                <span class="item-count">0.00 BDT</span>
                            </p>
                            <p class="item">
                                <span class="item-desc-comment">Penalties</span>
                                <span class="item-count">0.00 BDT</span>
                            </p>
                            <p class="item">
                                <span class="item-desc-comment">Other Debit</span>
                                <span class="item-count">0.00 BDT</span>
                            </p>
                            <p class="item">
                                <span class="item-desc-comment">VAT</span>
                                <span class="item-count">0.00 BDT</span>
                            </p>
                            <div class="subtotal">
                                <span class="item-desc-comment">VAT</span>
                                <span class="item-count">0.00 BDT</span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="statement-content">
                        <span class="invoice-comment">Other Services</span>
                        <div class="invoice-content">
                            <p class="item">
                                <span class="item-desc-comment">Subsidy</span>
                                <span class="item-count">0.00 BDT</span>
                            </p>
                            <p class="item">
                                <span class="item-desc-comment">Services</span>
                                <span class="item-count">0.00 BDT</span>
                            </p>
                            <p class="item">
                                <span class="item-desc-comment">Services</span>
                                <span class="item-count">0.00 BDT</span>
                            </p>
                            <p class="item">
                                <span class="item-desc-comment">Others</span>
                                <span class="item-count">0.00 BDT</span>
                            </p>
                            <p class="item">
                                <span class="item-desc-comment">Vat</span>
                                <span class="item-count">0.00 BDT</span>
                            </p>
                            <div class="subtotal">
                                <span class="item-desc-comment">VAT</span>
                                <span class="item-count">0.00 BDT</span>
                            </div>
                        </div>
                    </div>
                    <div class="invoice-footer">
                        <div class="invoice-footer-item">
                            <strong>Closing Balance</strong>
                            <p>Total Balance</p>
                            <span class="item-count">0.00 BDT</span>
                        </div>
                        <div class="invoice-footer-item">
                            <strong>Payout</strong>
                            <p>Estimated date of payout:13/July/2022 to 15/July/2022\n It will take a couple of days to reflect in your account statement.</p>
                            <span class="item-count">0.00 BDT</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content Body End -->

@stop

@push('js')
    <script>
        function currentDate(){
            var date = new Date();
            var day = date.getDate();
            var month = date.getMonth() + 1;
            var year = date.getFullYear();
            if (month < 10) month = "0" + month;
            if (day < 10) day = "0" + day;
            var today = year + "-" + month + "-" + day;
            document.getElementById('theDate').value = today;
        }
        currentDate()
    </script>
@endpush
