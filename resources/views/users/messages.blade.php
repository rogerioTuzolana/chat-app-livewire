@extends('layouts.app')
@section('content')
@section('title', 'Mensagens')
@section('path_route', 'Mensagens')

<div class="row justify-content-center mt-4">
    @foreach ($messages as $key=>$message)
    @if (json_decode($message->data)->tradingMessage->user_id_sent!= Auth::user()->id)  
        @php
            $user = App\Models\User::find(json_decode($message->data)->tradingMessage->user_id_sent);
            $status = App\Models\StatusMessage::where('trading_message_id',json_decode($message->data)->tradingMessage->id)->first();
        @endphp
        <a 
            href="{{route('chat',
            [
                Crypt::encryptString(json_decode($message->data)->tradingMessage->user_id_sent),
                //Crypt::encryptString(Auth::user()->id),
            ]
            )}}"
        >
        <div class="row notification {{($status!==NULL)? 'notif-color-true':'notif-color'}}" {{--id="notif-{{$key}}" data-id="{{$key}}" data-notif="{{$message->id}}"--}} style="cursor: pointer;border-radius:5px;border-bottom:solid 2px rgb(53, 87, 131);">
            <p>{{$user->name}}</p>
            @if (strlen(json_decode($message->data)->tradingMessage->customer_msg)>30)
            <p class="text-dark">{{substr(json_decode($message->data)->tradingMessage->customer_msg, 0, 30)}}...</p>
            @else
            <p class="text-dark">{{substr(json_decode($message->data)->tradingMessage->customer_msg, 0, strlen(json_decode($message->data)->tradingMessage->customer_msg))}}</p>
            @endif
            <p class="text-dark">{{date("Y-m-d H:i", strtotime(json_decode($message->data)->tradingMessage->created_at))}}</p>
        </div>
        </a>   
    @endif
    @endforeach
    {{--@foreach ($notifications as $notification)
    <div class="row" style="background:rgb(164, 202, 243);border-radius:5px;border-bottom:solid 2px rgb(53, 87, 131);">
        <a href="#">{{json_decode($notification->data)->adminMessage->title}}</a>
        @if (strlen(json_decode($notification->data)->adminMessage->message)>30)
        <p>{{substr(json_decode($notification->data)->adminMessage->message, 0, 30)}}...</p>
        @else
        <p>{{substr(json_decode($notification->data)->adminMessage->message, 0, strlen(json_decode($notification->data)->adminMessage->message))}}</p>
        @endif
        <p>{{date("Y-m-d H:i", strtotime(json_decode($notification->data)->adminMessage->created_at))}}</p>
            
    </div>
    @endforeach--}}

    {{--<div class="row mt-3">
        
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show text-center">
            <span>{{session('success')}}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if (session('fail'))
        <div class="alert alert-danger alert-dismissible fade show text-center">
            <span>{{session('fail')}}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
    </div>--}}
      
@endsection
