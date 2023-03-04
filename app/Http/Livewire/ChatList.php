<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TradingMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;


class ChatList extends Component
{
    public $messages;
    public $old_messages;
    public $sell_phone_id;
    public $listeners = ["messageReceived"];

    public function mount($chat_user_id){
        $this->messages = [];
        /*$this->sell_phone_id = Crypt::decryptString($sell_phone_id);
        $sell_phone = SellPhone::find($this->sell_phone_id);*/
        $dcrypt_chat_user_id = Crypt::decryptString($chat_user_id);
        $this->old_messages = TradingMessage::
        where("user_id_sent",$dcrypt_chat_user_id)
        ->orWhere("user_id_receive",Auth::user()->id)
        ->where("user_id_sent",Auth::user()->id)
        ->orWhere("user_id_receive",$dcrypt_chat_user_id)
        ->get();
        //dd($this->old_messages);
    }

    public function messageReceived($message){
        $this->messages[] = $message;
        //dd($this->messages);
    }

    public function render()
    {
        
        return view('livewire.chat-list');
    }
}
