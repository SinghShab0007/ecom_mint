@foreach($best_customers as $key => $customer)
    <div class="maan-note-card-body">
        <div class="dash-customar-author">
            @if($customer->image)
            <img src="{{URL::to('/frontend/img/users/'.$customer->image)}}" alt="">
            @else
                <div class="p-3">{{strtoupper(mb_substr($customer->first_name, 0, 1).mb_substr($customer->last_name, 0, 1))}}</div>
            @endif
            <div>
                <p>{{$customer->email??''}}</p>
                <h6>{{$customer->full_name()??''}}</h6>
            </div>
        </div>
        <div class="invoice">
            <a href="{{route('backend.orders.show',$customer->orders->first()->id??'#')}}">
                {{$customer->orders->first()->order_no??''}}
            </a>
        </div>
        <div class="date">
            <p>{{$customer->orders_count??0}} {{__('Order')}}</p>
        </div>
        <div class="date">
            <p>
                @if($customer->orders()->exists())
                    <b>{{ $customer->orders->first()->currency()}}{{ $customer->orders->sum('total_price')??0}}</b>
                @endif
            </p>
        </div>
    </div>
@endforeach
