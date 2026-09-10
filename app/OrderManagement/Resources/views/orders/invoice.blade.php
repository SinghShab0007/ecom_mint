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
                        <li><span>{{__('Name')}}:</span>{{$order->full_name()}}</li>
                        <li><span>{{__('Address')}}:</span> {{$order->user_address_1?? $order->user_address_2}} </li>
                        @if($order->user_mobile)
                        <li><span>{{__('Phone')}} :</span>{{$order->user_mobile??''}}</li>
                        @endif
                        @if($order->user_email)
                            <li><span>{{__('Email')}}:</span>{{$order->user_email??''}}</li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-6">
                <div class="billing-info">
                    <h4>{{__('Shipping Address')}}</h4>
                    <ul>
                        <li><span>{{__('Name')}}:</span> {{$order->shipping_name??''}}</li>
                        <li><span>{{__('Address')}}:</span> {{$order->shipping_address_1??$order->shipping_address_2}}
                        </li>
                        @if($order->shipping_mobile)
                        <li><span>{{__('Phone')}} :</span>
                            {{$order->shipping_mobile??''}}
                        </li>
                        @endif
                        @if($order->shipping_email)
                        <li><span>{{__('Email')}}:</span>
                            {{$order->shipping_email??''}}
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <h5><span>{{__('Invoice No')}}: </span>
            {{$order->order_no??''}}
        </h5>
        <h5><span>{{__('Invoice Date')}}: </span>{{date("d M Y ",strtotime($order->created_at))}}</h5>
        <h5><span>{{__('Sold By')}}: </span>
            {{ ucfirst($website->website_name)}}
        </h5>

    </div>
    <div class="mybazar-product-info-billing">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">{{__('Item')}}</th>
                <th scope="col">{{__('Color')}}</th>
                <th scope="col">{{__('Size')}}</th>
                <th scope="col">{{__('HRS')}}/{{__('QTY')}}</th>
                <th scope="col">{{__('Rate')}}</th>
                <th scope="col">{{__('Subtotal')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->details as $key => $detail)
                @if($detail->order_stat!=7)
                <tr data-product="{{$detail->product_id}}">
                    <td scope="row"> {{$detail->product->name??''}}
                        <p class="d-block">{{__('Shipping')}}: {{$detail->total_shipping_cost>0? $detail->shippingWithCurrency():'Free'}}</p>
                    </td>
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
            <li>{{__('Item(s) Subtotal')}}:<span>{{$order->productPriceWithCurrency()}}</span></li>
            <li>{{__('Shipping & Handling')}}:<span>{{$order->costWithCurrency()}}</span></li>
            <li>-------------------------------------------</li>
            <li>{{__('SubTotal')}}:<span>{{$order->totalWithCurrency()}}</span></li>
            <li>-------------------------------------------</li>
            <li>{{__('Total')}}:<span>{{$order->totalWithCurrency()}}</span></li>
        </ul>
    </div>
    <div class="signature">
        <p>signature</p>
    </div>
</div>
<!-- invoice end  -->
