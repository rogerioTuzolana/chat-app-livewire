@extends('layouts.app')

@section('content')
@section('title',"Chat")
<div class="container">
    <div class="row mt-2">
        @php
            $user = App\Models\User::find(Crypt::decryptString($chat_user_id));
        @endphp
        <h3>Chat - {{$user->name}}</h3>
        
        @livewire('chat-list',["chat_user_id" => $chat_user_id])
        
        @livewire('chat-form',["chat_user_id" => $chat_user_id])
        
    </div>
</div>
    
@endsection