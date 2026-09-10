<table class="table table-responsive-sm">
    <tbody>
    @foreach($best_selling_products as $key => $order)
        <tr>
            <td>
                <div
                    class="maan-appoint-image maan-radius d-flex align-items-center">
                    @if($order->product()->exists() && $order->product->images()->exists() && $order->product->images->first()->image)
                        <img class="mr-2"
                             src="{{URL::to('uploads/products/galleries/' . $order->product->images->first()->image??'')}}"
                             alt="productImage">
                    @else
                        <img class="mr-2"
                             src="{{URL::to('uploads/products/galleries/default.jpg')}}"
                             alt="productImage">
                    @endif
                    <div class="media-body">
                        <p class="mb-0 maan-chart-title fs">{{$order->product->name??''}}</p>
                    </div>
                </div>
            </td>
            <td>
                <p class="maan-date mb-0">{{$website_appearance->currency->symbol}}{{$order->product->sale_price??''}} </p>
            </td>
            <td>
                <div class="align-items-center">
                    <div class="maan-appoint-status maan-app-radius">
                        @if($order->product()->exists() && $order->product->details()->exists() && $order->product->quantity > $order->product->details->warning_quantity)
                            <span class="maan-title maan-bg-soft-success">{{__('In-Stock')}}</span>
                        @else
                            <span class="maan-title maan-bg-soft-danger">{{__('Out of Stock')}}</span>
                        @endif
                    </div>
                </div>
            </td>
        </tr>
    @endforeach

    </tbody>
</table>
