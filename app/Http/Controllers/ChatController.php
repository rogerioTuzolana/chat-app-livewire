<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use App\Models\User;
use App\Models\Notification;


class ChatController extends Controller
{
    public function index($user_id){
        $decrypt_user_id = Crypt::decryptString($user_id);

        return view("home.index",["chat_user_id"=>$user_id]);
    }
}
