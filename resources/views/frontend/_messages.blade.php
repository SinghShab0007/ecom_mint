@foreach($messages as $message)
    @if($message->sender == 'customer')
        <li class="clearfix">
            <div class="message-data align-right">
                <span class="message-data-time" >{{ $message->created_at }}</span> &nbsp; &nbsp;
                <span class="message-data-name" >{{ $message->user->first_name }}</span>
            </div>
            <div class="message other-message float-right">
                {{ $message->message }}
            </div>
        </li>
    @else
        <li>
            <div class="message-data">
                <span class="message-data-name"><i class="fa fa-circle online"></i> {{ $message->seller->company_name }}</span>
                <span class="message-data-time">{{ $message->created_at }}</span>
            </div>
            <div class="message my-message">
                {{ $message->message }}
            </div>
        </li>
    @endif
@endforeach
