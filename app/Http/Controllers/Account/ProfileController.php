<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;

use App\Models\User;
use App\Models\Notification;
use App\Models\StatusMessage;
use App\Models\TradingMessage;
use App\Notifications\NotifyUser;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function notifications(){
        $notifications = Notification::where('type','App\Notifications\NotifyMessage')->where('read_at',null)->get();
        return view('users.notifications',['notifications'=>$notifications]);
    }

    public function messages(){
        $messages = Notification::where('type','App\Notifications\NotifyUser')->where('read_at',null)->get();
        return view('users.messages',['messages'=>$messages]);
    }

    public function view_notification(Request $request){
        $notification = Notification::find($request->notif_id);
        
        if (isset($notification)) {
            $title = json_decode($notification->data)->adminMessage->title;
            $message = json_decode($notification->data)->adminMessage->message;

            $status_message = StatusMessage::where('user_id',auth()->user()->id)->where('admin_message_id',json_decode($notification->data)->adminMessage->id)->first();
            if (empty($status_message)) {
                $status_message = new StatusMessage();
                $status_message->status = true;
                $status_message->user_id = auth()->user()->id;
                $status_message->admin_message_id = json_decode($notification->data)->adminMessage->id;
                $status_message->save();
            }
            $count = count(Notification::where('type','App\Notifications\NotifyMessage')->where('read_at',null)->get()) - count(StatusMessage::all());
            return response()->json([
                'success' => true,
                'status' => $status_message->status,
                'title' => $title,
                'count' => $count,
                'message' => $message,
            ],200);
        }
        return response()->json([
            'success' => false,
            'message' => "Algo deu errado, nas notificações!",
        ],422);
        
    }
    
    public function change_password(Request $request){
        $request->validate([
            'oldPass' => 'required',
            'newPass' => 'required|min:8',
            'cPass' => 'required|min:8|same:newPass',
            //'bi' => 'required|unique:national_users,bi',
            ],
        );
        //$2y$10$QdlFmse4InAXhy7TXtqkweP5faAWjFVkte6EPmtRgi/E2IxN13ZkO
        $status = false;
        //$email_exists = User::where('email',auth()->user()->email)->where('password',$request->oldPass)->first();

        if(password_verify($request->oldPass,auth()->user()->password)){
            $user = User::find(auth()->user()->id);
            $user->password = Hash::make($request->newPass);
            $status = $user->update();
        }else {
            return response()->json([
                'success' => false,
                'message' => "A senha antiga está incorreta!",
            ],422);
        }

        if ($status == false) {
            return response()->json([
                'success' => false,
                'message' => "Algo deu errado, Senha incorreta!",
            ],422);
        }
        if ($status == true) {
            return response()->json([
                'success' => true,
                'message' => "Senha alterada!",
            ],200);
        }
    }

    public function photo_profile(Request $request){
        
        $user = User::findOrFail(auth()->user()->id);
        //
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            
            $requestImage = $request->image;
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime('now')) . "." . $extension;
            $request->image->move(public_path('img/profile'), $imageName);
   
            $user = User::find($user->id);
            $user->image = $imageName;
            $status = $user->update();
 
        }
        return redirect()->back();
    }


    
    

    public function list_users(){
        $search = request('search');
        if ($search) {
            $users = User::where([
                ['name', 'like', '%'.$search.'%']
            ])->orWhere([
                ['email', 'like', '%'.$search.'%']
            ])
            ->paginate(6);
        }else{
            $users = User::paginate(6);
        }
        return view('users.list_users',["users"=>$users, "search"=>$search]);
        //return view('users.marketplace');
    }

    

    public function sendMessageBuy(Request $request){
        $trading_message = new TradingMessage();
        $trading_message->customer_msg = $request->customer_msg;
        $trading_message->sell_phone_id = $request->sell_phone_id;
        $trading_message->user_id = auth()->user()->id;
        $status = $trading_message->save();
        if ($status) {
            $auth = $trading_message->user;
            
            $auth->notify(new NotifyUser($trading_message));
            return response()->json([
                'success' => true,
                'message' => "Mensagem enviada com sucesso.",
            ],200);
        }else {
            return response()->json([
                'success' => false,
                'message' => "Algo deu errado, telemóvel não encontrado.",
            ],500);
        }
    }
    public function my_publication(){
        $sell_phones = '';
        $search = request('search');
        if ($search) {
            $sell_phones = SellPhone::where('user_id', auth()->user()->id)->where([
                ['title', 'like', '%'.$search.'%']
            ])->orWhere([
                ['description', 'like', '%'.$search.'%']
            ])->orWhere([
                ['price', 'like', '%'.$search.'%']
            ])
            ->paginate(3);
        }else{
            $sell_phones = SellPhone::where('user_id', auth()->user()->id)->paginate(3);
        }
        return view('users.my_publication',["sell_phones"=>$sell_phones, "search"=>$search]);
    }
    

  
    public function update_profile(Request $request){
        $user = User::findOrFail(auth()->user()->id);
        $user->nsame = $request->name;
        $user->email = $request->email;
        
        $status = $user->update();
        
        if ($status) {
            //return redirect()->back()->with('success','Perfil editado com sucesso');
            return response()->json([
                'success' => true,
                'message' => 'Perfil atualizado com sucesso!',
            ],200);
        }else {
            return response()->json([
                'success' => false,
                'message' => 'Perfil não atualizado, verifique os campos.',
            ],422);
            return response()->json([
                'success' => false,
                'message' => 'Algo deu errado, dados não atualizado.',
            ],500);
        }
    }

    /*public function pub_delete(Request $request){
        $sell_phone = SellPhone::find($request->pub_id);
        $file_1 = 'img/marketplace/'.$sell_phone->front_img;
        $file_2 = 'img/marketplace/'.$sell_phone->back_img;

        if (File::exists($file_1) && File::exists($file_2)) {
            File::delete($file_1);
            File::delete($file_2);
            $sell_phone->delete();
            return response()->json([
                'success' => true,
                'message' => 'Publicação eliminada.',
            ],200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Algo deu errado, publicação não eliminada.',
        ],500);
        
    }*/

}
