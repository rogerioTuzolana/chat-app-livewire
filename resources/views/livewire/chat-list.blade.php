<div class="row">
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <div class="col-lg-2 col-md-2"></div>
    <div class="row col-lg-8 col-md-8 mb-4 mt-4">
        @foreach ($old_messages as $old_message)
        @php    
            $user = App\Models\User::find($old_message["user_id_sent"]);
        @endphp
            
            <div class="container mb-2
                @if($old_message["user_id_sent"] == Auth::user()->id)
                bg-primary text-white
                @else
                text-dark
                @endif" 
                style="border-radius: 15px;
                @if($old_message["user_id_sent"] == Auth::user()->id)
                    margin-right: 50px;
                @else
                    margin-left: 50px;
                    background: #ababb9;
                @endif"
            >
                <label><small>{{$user->name}}</small></label>
                <p class="mt-3">{{$old_message["customer_msg"]}}</p>
                <div class="row">
                    <small>{{$old_message["created_at"]->diffForHumans()}}</small>
                </div>
            </div>   
            
            {{--@if($old_message["user_id_receive"] == Auth::user()->id)
            <div class="container bg-light text-dark mb-2" style="border-radius: 15px;margin-left: 50px;">
                <label><small>{{$user->name}}</small></label>
                <p class="mt-3">{{$old_message["customer_msg"]}}</p>
            </div>
            @endif--}}
        @endforeach

        @foreach ($messages as $message)
            {{--@if($message["user_id"])
            <div class="container bg-primary text-white mb-2" style="border-radius: 15px;margin-right: 50px;">
                <label><small>{{$message["user_name"]}}</small></label>
                <p class="mt-3">{{$message["message"]}}</p>
            </div>   
            @else
            <div class="container bg-light text-dark mb-2" style="border-radius: 15px;margin-left: 50px;">
                <label><small>{{$message["user_name"]}}</small></label>
                <p class="mt-3">{{$message["message"]}}</p>
            </div>
            @endif--}}
            <div class="container mb-2
                @if($message["user_id"] == Auth::user()->id)
                bg-primary text-white
                @else
                text-dark
                @endif" 
                style="border-radius: 15px;
                @if($message["user_id"] == Auth::user()->id)
                    margin-right: 50px;
                @else
                    margin-left: 50px;
                    background: #ababb9;
                @endif"
            >
                <label><small>{{$message["user_name"]}}</small></label>
                <p class="mt-3">{{$message["message"]}}</p>
                <div class="row">
                    <small>{{\Carbon\Carbon::parse($message["created_at"])->diffForHumans()}}</small>
                </div>
            </div>
        @endforeach
    </div>

    <script>

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;
    
        var pusher = new Pusher('{{env('PUSHER_APP_KEY')}}', {
          cluster: '{{env('PUSHER_APP_CLUSTER')}}',
        });
    
        var channel = pusher.subscribe('chat-channel');
        channel.bind('chat-event', function(data) {
          //alert(JSON.stringify(data));
          window.livewire.emit("messageReceived",data);
        });
    </script>
</div>
