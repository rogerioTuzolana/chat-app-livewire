@extends('layouts.app')
@section('content')
@section('title', 'Notificações')
@section('path_route', 'Notificações')

<div class="row justify-content-center mt-4">
    @foreach ($notifications as $key=>$notification)
    @php
        $status = App\Models\StatusMessage::where('admin_message_id',json_decode($notification->data)->adminMessage->id)->first();
    @endphp
    <div class="row notification {{($status!==NULL)? 'notif-color-true':'notif-color'}}" id="notif-{{$key}}" data-id="{{$key}}" data-notif="{{$notification->id}}" style="cursor: pointer;border-radius:5px;border-bottom:solid 2px rgb(53, 87, 131);">
        <a href="#">{{json_decode($notification->data)->adminMessage->title}}</a>
        @if (strlen(json_decode($notification->data)->adminMessage->message)>30)
        <p>{{substr(json_decode($notification->data)->adminMessage->message, 0, 30)}}...</p>
        @else
        <p>{{substr(json_decode($notification->data)->adminMessage->message, 0, strlen(json_decode($notification->data)->adminMessage->message))}}</p>
        @endif
        <p>{{date("Y-m-d H:i", strtotime(json_decode($notification->data)->adminMessage->created_at))}}</p>
    </div>
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
