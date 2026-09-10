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
    <div class="content-body">
        <div class="container d-print-block">
            <nav class="d-print-none">
                <div class="nav nav-tabs nav-justified" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                            type="button"
                            role="tab" aria-controls="nav-home" aria-selected="true">{{__('Order Details')}}
                    </button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                            type="button"
                            role="tab" aria-controls="nav-profile" aria-selected="false">{{__('Invoice')}}
                    </button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active d-print-none" id="nav-home" role="tabpanel"
                     aria-labelledby="nav-home-tab">
                    <div class="invoice d-print-block">
                        <div class="invoice-title">
                            <h6>{{__('INVOICE')}}#
                                {{$order->order_no??''}}
                            </h6>
                            <p>CREATED AT {{date("d M Y h:i A",strtotime($order->created_at))}}</p>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card order-item">
                                    <div class="mybazar-product-info-billing" id="order_details">
                                        <div class="card-header">
                                            <h6>{{__('Item Details')}}</h6>
                                        </div>
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th scope="col">{{__('Item')}}</th>
                                                <th scope="col">{{__('Color')}}</th>
                                                <th scope="col">{{__('Size')}}</th>
                                                <th scope="col">{{__('HRS')}}/{{__('QTY')}}</th>
                                                <th scope="col">{{__('Rate')}}</th>
                                                <th scope="col">{{__('Subtotal')}}</th>
                                                <th scope="col">{{__('Status')}}</th>
                                                <th scope="col">{{__('Action')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($order->details as $key => $detail)
                                                <tr data-product="{{$detail->product_id}}">
                                                    <td scope="row"> {{$detail->product->name??''}}
                                                    </td>
                                                    <td>{{$detail->color??''}}</td>
                                                    <td>{{$detail->size??''}}</td>
                                                    <td>{{$detail->qty??''}}</td>
                                                    <td>{{$detail->sale_price??''}}</td>
                                                    <td>{{$detail->total_price??''}}</td>
                                                    <td>
                                                        <div class="invoice-title">
                                                            <h6>
                                                                @if (optional($detail->orderStatus)->name == 'PENDING')
                                                                    <span class="badge bg-warning">{{ $detail->orderStatus->name ?? '' }}</span>
                                                                @elseif (optional($detail->orderStatus)->name == 'CONFIRMED')
                                                                    <span class="badge bg-info">{{ $detail->orderStatus->name ?? '' }}</span>
                                                                @elseif (optional($detail->orderStatus)->name == 'PROCESSING')
                                                                    <span class="badge bg-primary">{{ $detail->orderStatus->name ?? '' }}</span>
                                                                @elseif (optional($detail->orderStatus)->name == 'PICKED')
                                                                    <span class="badge bg-secondary">{{ $detail->orderStatus->name ?? '' }}</span>
                                                                @elseif (optional($detail->orderStatus)->name == 'SHIPPED')
                                                                    <span class="badge bg-light text-dark border">{{ $detail->orderStatus->name ?? '' }}</span>
                                                                @elseif (optional($detail->orderStatus)->name == 'DELIVERED')
                                                                    <span class="badge bg-success">{{ $detail->orderStatus->name ?? '' }}</span>
                                                                @elseif (optional($detail->orderStatus)->name == 'CANCELLED')
                                                                    <span class="badge bg-danger">{{ $detail->orderStatus->name ?? '' }}</span>
                                                                @elseif (optional($detail->orderStatus)->name == 'RETURNED')
                                                                    <span class="badge bg-dark">{{ $detail->orderStatus->name ?? '' }}</span>
                                                                @endif
                                                            </h6>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button class="update-order-btn btn btn-warning btn-sm" data-product_id="{{$detail->product_id}}" data-orders_details_id="{{$detail->id}}">
                                                            <b>{{__('Change Status')}}</b>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mybazar-total-info">
                                        <ul>
                                            <li>{{__('Item(s) Subtotal')}}
                                                :<span>{{$order->productPriceWithCurrency()}}</span></li>
                                            <li>{{__('Shipping & Handling')}}
                                                :<span>{{$order->costWithCurrency()}}</span></li>
                                            <li>-------------------------------------------</li>
                                            <li>{{__('SubTotal')}}:<span>{{$order->totalWithCurrency()}}</span></li>
                                            <li>-------------------------------------------</li>
                                            <li>{{__('Total')}}:<span>{{$order->totalWithCurrency()}}</span></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card timeline-item d-print-none">
                                    <div class="card-header">
                                        <h6>{{__('Timeline')}}</h6>
                                        <span>{{__('Click on item to see timeline')}}</span>
                                    </div>
                                    <div class="card-body">
                                        <ul>
                                            @foreach($order->details as $key => $detail)
                                                @foreach($detail->timelines as $index => $timeline)
                                                    <li class="d-none product_{{$timeline->product_id}}">
                                                        <div class="time">
                                                            {{$timeline->order_stat_datetime}}
                                                            <span></span></div>
                                                        <p>
                                                            {{$timeline->order_stat_desc??''}}
                                                        </p>
                                                        <div class="option refunded">{{$timeline->status->name??''}}</div>
                                                    </li>
                                                @endforeach
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    @include('ordermanagement::orders.invoice')
                </div>
            </div>

        </div>

        <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel">{{__('Update')}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ auth('seller')->user() ? url('/seller/orders_details') : url('/admin/orders_details') }}" class="ajaxform_instant_reload" method="post">
                            @csrf() 
                            @method("PUT")

                            <input type="hidden" name="order_id" value="{{$order->id}}">
                            <input type="hidden" name="orders_details_id" id="orders_details_id" value="">
                            <input type="hidden" name="product_id" id="product_id" value="">
                            <div class="mb-3 form-group input-group row">
                                <label for="message-text" class="col-form-label col-md-4">{{__('Status')}}</label>
                                <select name="order_stat" class="form-control col-md-6" required>
                                    <option value="">{{__('Select Status')}}</option>
                                    <option value="1">{{__('Pending')}}</option>
                                    <option value="2">{{__('Confirmed')}}</option>
                                    <option value="3">{{__('Processing')}}</option>
                                    <option value="4">{{__('Picked')}}</option>
                                    <option value="5">{{__('Shipped')}}</option>
                                    <option value="6">{{__('Delivered')}}</option>
                                    <option value="7">{{__('Cancelled')}}</option>
                                </select>
                            </div>
                            <div class="mb-3 form-group input-group row">
                                <label for="message-text" class="col-form-label col-md-4">{{__('Description')}}</label>
                                <textarea name="order_stat_desc" rows="3" class="form-control col-md-6" required></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary submit-btn"><i class="fa-solid fa-floppy-disk-circle-arrow-right"></i> {{__('Save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>

        $(function () {
            "use strict";

            $(document).ready(function () {

                function highlight(e) {
                    if (selected[0])
                        selected[0].className = '';
                    e.target.parentNode.className = 'selected';
                }

                var table = document.querySelector('#order_details .table'),
                    selected = table.getElementsByClassName('selected');
                table.onclick = highlight;

                $('.update-order-btn').on('click', function() {
                    var detail_id = $(this).data('orders_details_id');
                    var product_id = $(this).data('product_id');
                    $('#orders_details_id').val(detail_id);
                    $('#product_id').val(product_id);
                    $("#updateModal").modal('show')
                })

                $(document).on('click', '#order_details .table tr', function () {
                    let product = $(this).data('product');
                    $(document).find('.timeline-item ul').find('li').addClass('d-none');
                    $(document).find('.timeline-item ul').find('.product_' + product).removeClass('d-none');
                });

                $('#updateModal').on('hidden.bs.modal', function(event) {
                    $(this).find('form').trigger('reset');
                });
            });
        });
    </script>
@endpush
