@extends('backend.layouts.app')
@section('title','Orders - ')
@push('css')
    <style>

        /* my bazar invoice css */

        .maan-mybazar-invoice {
            max-width: 1200px;
            margin: 0 auto;
            padding: 50px;
        }

        .my-bazar-invoice-header {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .my-bazar-invoice-header .logo {
            display: block;
        }

        .my-bazar-invoice-header .logo img {
            max-width: 100%;
        }

        .my-bazar-invoice-header .customer-detail {
            text-align: right;
        }

        .my-bazar-invoice-header .customer-detail p {
            font-size: 14px;
            font-weight: 400;
            padding: 0;
        }

        .mybazar-billing-info .billing-info {
            padding: 15px 30px;
            border: 1px dashed #ddd;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 20px;
            height: 200px;
        }

        .mybazar-billing-info .billing-info h4 {
            font-size: 18px;
            font-weight: 700;
        }

        .mybazar-billing-info .billing-info ul li {
            font-size: 14px;
            font-weight: 400;
            display: flex;
            align-items: center;
            line-height: 24px;
        }

        .mybazar-billing-info .billing-info ul li span {
            width: 80px;
            font-weight: 500;
        }

        .mybazar-billing-info h5 {
            font-weight: 400;
            font-size: 14px;
            display: flex;
            align-items: center;
        }

        .mybazar-billing-info h5 span {
            font-weight: 700;
            width: 100px;
        }

        .mybazar-product-info-billing {
            margin-top: 30px;
        }

        .mybazar-product-info-billing .table thead tr {
            text-align: center;
            background: #eee;
            border-bottom: 1px solid #ddd;
        }

        .mybazar-product-info-billing .table thead tr th {
            font-size: 14px;
            font-weight: 600;
            padding: 20px;
            border-bottom: 1px solid #ddd;
        }

        .mybazar-product-info-billing .table thead tr th:first-child {
            text-align: left;
        }

        .mybazar-product-info-billing .table tbody {
            border: none;
        }

        .mybazar-product-info-billing .table tbody tr {
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        .mybazar-product-info-billing .table tbody tr td {
            font-size: 14px;
            font-weight: 400;
            border-bottom: 1px solid #ddd;
            padding: 15px;
        }

        .mybazar-product-info-billing .table tbody tr td:first-child {
            text-align: left;
        }

        .mybazar-total-info {
            text-align: right;
            margin-top: 30px;
        }

        .mybazar-total-info ul li {
            text-align: right;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: end;
            -ms-flex-pack: end;
            justify-content: flex-end;
            font-size: 14px;
        }

        .mybazar-total-info ul li span {
            max-width: 160px;
            display: block;
            width: 100%;
        }

        .mybazar-total-info ul li:last-child {
            font-weight: 700;
        }

        .signature {
            margin-top: 30px;
        }
    </style>
@endpush
@section('content')
<!-- invoice start  -->
<div class="maan-mybazar-invoice">
    <div class="my-bazar-invoice-header">
        <a href="" class="logo">
            <img src="@if($website->logo){{URL::to('uploads').'/'.$website->logo}} @else 'uploads/logo.png' @endif"
                 width="150" alt="logo">
        </a>
        <button class="maan-print-btn d-print-none" onclick="window.print()">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1"
                 x="0px" y="0px" width="45px" height="45px" viewBox="0 0 45 45" style="enable-background:new 0 0 45 45;"
                 xml:space="preserve">
        <path d="M42.5,19.408H40V1.843c0-0.69-0.561-1.25-1.25-1.25H6.25C5.56,0.593,5,1.153,5,1.843v17.563H2.5   c-1.381,0-2.5,1.119-2.5,2.5v20c0,1.381,1.119,2.5,2.5,2.5h40c1.381,0,2.5-1.119,2.5-2.5v-20C45,20.525,43.881,19.408,42.5,19.408z    M32.531,38.094H12.468v-5h20.063V38.094z M37.5,19.408H35c-1.381,0-2.5,1.119-2.5,2.5v5h-20v-5c0-1.381-1.119-2.5-2.5-2.5H7.5   V3.093h30V19.408z M32.5,8.792h-20c-0.69,0-1.25-0.56-1.25-1.25s0.56-1.25,1.25-1.25h20c0.689,0,1.25,0.56,1.25,1.25   S33.189,8.792,32.5,8.792z M32.5,13.792h-20c-0.69,0-1.25-0.56-1.25-1.25s0.56-1.25,1.25-1.25h20c0.689,0,1.25,0.56,1.25,1.25   S33.189,13.792,32.5,13.792z M32.5,18.792h-20c-0.69,0-1.25-0.56-1.25-1.25s0.56-1.25,1.25-1.25h20c0.689,0,1.25,0.56,1.25,1.25   S33.189,18.792,32.5,18.792z"></path>
        </svg>
        </button>
        <div class="customer-detail">
            <p><b>{{ ucfirst($website->website_name)}}</b></p>
            <p>{{$website->get_in_touch??''}}</p>
            <p>{{ucfirst($website->city).'-'.$website->post_code??''}}</p>
            <p>{{$website->country->name??''}}</p>
            <p>{{$website->email??''}}</p>
        </div>
    </div>
    <div class="mybazar-billing-info">
        <div class="row">
            <div class="col-6">
                <div class="billing-info">
                    <h4>{{__('Billing Address')}}</h4>
                    <ul>
                        <li><span>{{__('Name')}}:</span>{{$orderDetails[0]->order->full_name()}}</li>
                        @if($orderDetails[0]->order->user_mobile)
                            <li><span>{{__('Phone')}} :</span>{{$orderDetails[0]->order->user_mobile??''}}</li>
                        @endif
                        <li><span>{{__('Address')}}:</span> {{ $orderDetails[0]->order->shipping_address_2 }} </li>

                    </ul>
                </div>
            </div>
            <div class="col-6">
                <div class="billing-info">
                    <h4>{{__('Shipping Address')}}</h4>
                    <ul>
                        <li> {{ $orderDetails[0]->order->shipping_address_1 }}
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <h5><span>{{__('Invoice No')}}: </span>
            {{ $orderDetails[0]->order->order_no ?? '' }}
        </h5>
        <h5><span>{{__('Invoice Date')}}: </span>{{date("d M Y ",strtotime($orderDetails[0]->order->created_at))}}</h5>
        <h5><span>{{__('Sold By')}}: </span>
            {{ $orderDetails[0]->seller->company_name ?? ucfirst($website->website_name)}}
        </h5>
    </div>
    <div class="mybazar-product-info-billing">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">{{__('Item')}}</th>
                {{-- <th scope="col">{{__('Courier')}}</th> --}}
                <th scope="col">{{__('Color')}}</th>
                <th scope="col">{{__('Size')}}</th>
                <th scope="col">{{__('HRS')}}/{{__('QTY')}}</th>
                <th scope="col">{{__('Rate')}}</th>
                <th scope="col">{{__('Subtotal')}}</th>
            </tr>
            </thead>
            <tbody id="seller-invoice-table1">
            @php
            $sellerId =  "<script>document.writeln(seller_id);</script>";
            @endphp
            @foreach($orderDetails as $key => $detail)
                @if($detail->order_stat!=7)
                <tr data-product="{{$detail->product_id}}">
                    <td scope="row"> {{$detail->product->name??''}}
                        <p class="d-block">{{__('Shipping')}}: {{$detail->total_shipping_cost>0? $detail->shippingWithCurrency():'Free'}}</p>
                    </td>
                    {{-- <td>{{$detail->courier??''}}</td> --}}
                    <td>{{$detail->color??''}}</td>
                    <td>{{$detail->size??''}}</td>
                    <td>{{$detail->qty??''}}</td>
                    <td>{{$detail->sale_price??''}}</td>
                    <td>{{$detail->total_price??''}}</td>
                </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="mybazar-total-info">
        <ul>
            <li>{{__('Item(s) Subtotal')}}:<span>{{ currency($orderDetails->sum('total_price')) }}</span></li>
            <li>{{__('Shipping Charge')}}:<span>{{ currency($orderDetails->sum('total_shipping_cost'))}}</span></li>
            <li>-------------------------------------------</li>
            <li>{{__('SubTotal')}}:<span>{{  currency($orderDetails->sum('total_price') + $orderDetails->sum('total_shipping_cost')) }}</span></li>
<!--            <li>{{__('Coupon')}}:<span>{{--{{ $order->totalCouponDiscount()  }}--}}</span></li>-->
            {{--  <li>{{__('Vat')}}:<span>{{ $order->totalVat() }}</span></li>  --}}
            <li>-------------------------------------------</li>
            <li>{{__('Total')}}:<span>{{ currency($orderDetails->sum('total_price') + $orderDetails->sum('total_shipping_cost'))  }}</span></li>
        </ul>
    </div>
    <div class="signature">
        <p>signature</p>
    </div>
</div>
<!-- invoice end  -->
@endsection

@push('js')

@endpush
