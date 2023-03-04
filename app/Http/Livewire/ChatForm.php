<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Events\SendMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Models\TradingMessage;
use App\Notifications\NotifyUser;

class ChatForm extends Component
{
    public $user_name;
    public $user_id;
    public $message;
    public $chat_user_id;
    /*public $user_id_receive;
    public $user_id_sent;*/

    public function mount($chat_user_id){
        $this->user_name = Auth::user()->name;
        $this->user_id = Auth::user()->id;

        $this->chat_user_id = Crypt::decryptString($chat_user_id);
        
        /*$this->chat_user_id = ""
        $this->chat_user_id = ""
        $this->chat_user_id = ""*/
        $this->message = "";
    }

    public function render()
    {
        return view('livewire.chat-form');
    }

    public function updated($field){
        $this->validateOnly($field, [
            //"name"=> "required|min:3",
            "message"=> "required",
            "user_id"=> "required",
            "chat_user_id"=> "required",
        ],
        [
            //"name.required"=>"Nome é um campo obrigatório",
            "message.required"=>"Mensagem é um campo obrigatório",
            //"min"=>"O Nome deve conter no mínimo 3 caracteres",
        ]);
    }

    public function sendMessage(){
        $this->validate([
            //"name"=> "required|min:3",
            "message"=> "required",
            "user_id"=> "required",
            "chat_user_id"=> "required",
        ],
        [
            //"name.required"=>"Nome é um campo obrigatório",
            "message.required"=>"Mensagem é um campo obrigatório",
            //"min"=>"O Nome deve conter no mínimo 3 caracteres",
        ]);

        $this->emit("messageSent");
        $datas = [
            "user_name" => $this->user_name,
            "user_id" => $this->user_id,
            "message" => $this->message,
        ];
        //dd($this->sell_phone_id);
        $trading_message = new TradingMessage();
        $trading_message->customer_msg = $this->message;
        
        $trading_message->user_id_sent = $this->user_id;
        $trading_message->user_id = $this->user_id;
        $trading_message->user_id_receive = intval($this->chat_user_id);
        $status = $trading_message->save();
        if ($status) {
            $auth = $trading_message->user;
            //dd($auth);
            $datas["created_at"] = $trading_message->created_at;
            $auth->notify(new NotifyUser($trading_message));
            
        }else {
            /*return response()->json([
                'success' => false,
                'message' => "Algo deu errado, telemóvel não encontrado.",
            ],500);*/
        }

        //$this->emit("messageReceived",$datas);
        
        event(new SendMessage($this->user_name, $this->user_id, $this->message,$datas["created_at"]));
        $this->message = "";
    }
}
