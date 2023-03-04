<?php

namespace App\Http\Controllers;

use App\Mail\PasswordResetAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

use App\Models\PasswordReset;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    //
    public function index(){
        $user = auth()->user();
        

        
        return view('users.home',["user"=>$user]);
    }

    public function login(){
        return view('auth.login');
    }
    
    public function auth(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ],[
            'email.exists' => 'Não existe este email'
        ]);
        $data = $request->only('email','password');

        if(Auth::attempt($data)){
            if(auth()->user()->type == 'user'){
                return redirect()->route('home');
                /*return response()->json([
                    'success' => true,
                    'message' => auth()->user()->type,
                ],200);*/
            }else {
               return redirect()->route('dashboard');
               /*return response()->json([
                'success' => true,
                'message' => 'admin',
                ],200);*/
            }
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Email ou Senha errada.',
            ],422);
            //return redirect()->back()->with('fail','Credencial incorretas');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }

    public function register(){
        return view('auth.register');
    }

    public function forgot_password(Request $request){
        $userExists = User::where('email', $request->email)->first();
        if (!$userExists) {
            return response()->json([
                'success' => false,
                'message' => "Não existe uma conta com este email!",
            ],422);
        }
        //dd('uu');
        $password_reset = new PasswordReset();
        $password_reset->email = $request->email;
        $password_reset->token = md5(rand());
        $status = $password_reset->save();
        if ($status) {

            Mail::to(/*$password_reset->email*/'tuzolanarogerio@gmail.com')->send(new PasswordResetAccount($password_reset));

            return response()->json([
                'success' => true,
                'message' => "Pedido enviado!",
            ],200);

        }else{
            return response()->json([
                'success' => false,
                'message' => "Algo deu errado, pedido não enviado!",
            ],500);
        }
    }

    public function recover_password($token){
        $password_reset = PasswordReset::where('token',$token)->first();
        if ($password_reset) {
            return view('layouts.home',["password_reset"=>$password_reset]);        
        }else{
            return view('layouts.home');
        }
        
    }

    public function change_password(Request $request){

        $request->validate([
            'email' => 'required',
            'password' => 'required|min:8',
            'cpassword' => 'required|min:8|same:password',
            ],
        );

        $status = false;
        $user = User::where('email',$request->email)->first();

        if($user){
            $user->password = Hash::make($request->password);
            $status = $user->update();

        }else {
            return response()->json([
                'success' => false,
                'message' => "Algo deu errado, Senha não alterada!!",
            ],422);
        }

        if ($status == true) {
            $password_reset = PasswordReset::where('email',$request->email)->first();
            $password_reset->delete();
            
            $data = $request->only('email','password');

            if(Auth::attempt($data)){
                if(auth()->user()->type == 'user' || auth()->user()->type == 'agents'){

                    return response()->json([
                        'success' => true,
                        'message' => auth()->user()->type,
                    ],200);
                }else {

                    return response()->json([
                        'success' => true,
                        'message' => 'admin',
                    ],200);
                }
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Email ou Senha errada.',
                ],422);
            }
        }

        if ($status == false) {
            return response()->json([
                'success' => false,
                'message' => "Algo deu errado, Senha não alterada!",
            ],422);
        }
        
        
    }

    public function create(Request $request){
        
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|'/*unique:users,email'*/,
            'password' => 'required|min:8|max:255|',
            'cpassword' => 'required|min:8|same:password',
            //'accepterms' => 'required',
            //'bi' => 'required|unique:national_users,bi',
        ],
        );

        $email_exists = User::where('email',$request->email)->first();
        if ($email_exists != NULL) {
            return response()->json([
                'success' => false,
                'message' => "Já existe está conta.",
            ],422);
        }
        /*if ($request->accepterms != 'on') {
            return response()->json([
                'success' => false,
                'message' => "Aceite os termos.",
            ],422);
        }*/
        
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $status = $user->save();
        
        if ($status && $status_2) {
            //return redirect()->back()->with('success','Cadastrado com sucesso');
            /*return response()->json([
                'success' => false,
                'message' => 'Cadastrado com sucesso.',
            ],200);*/
            $data = $request->only('email','password');
            if(Auth::attempt($data)){
                if(auth()->user()->type == 'user'){
                    return redirect()->route('minha-conta');
                    /*return response()->json([
                        'success' => true,
                        'message' => auth()->user()->type,
                    ],200);*/
                }else if(auth()->user()->type == 'admin'){
                    return redirect()->route('dashboard');
                    /*return response()->json([
                        'success' => true,
                        'message' => 'admin',
                    ],200);*/
                }
            }
        }else {
            return redirect()->back()->with('fail','Algo deu errado, dados não Cadastrado');
            /*return response()->json([
                'success' => false,
                'message' => 'Algo deu errado, dados não Cadastrado.',
            ],500);*/
        }
    }

    public function update(Request $request){
        $national_user = NationalUser::where('user_id',auth()->user()->id)->first();
        $foreign_user = ForeignUser::where('user_id',auth()->user()->id)->first();
        $company = Company::where('user_id',auth()->user()->id)->first();
        $status = false;

        if (isset($national_user) && auth()->user()->class == 'nt') {
            $national_user = NationalUser::findOrFail(auth()->user()->id);
            $national_user->location = $request->location;
            $status = $national_user->update();

        }elseif(isset($foreign_user) && auth()->user()->class == 'fg'){
            $foreign_user = ForeignUser::findOrFail(auth()->user()->id);
            $foreign_user->name = $request->name;
            $foreign_user->gender = $request->gender;
            $foreign_user->passport_number = $request->passport_number;
            $foreign_user->birth_date = $request->birth_date;
            $foreign_user->contact = $request->contact;
            $foreign_user->location = $request->location;
            $status = $foreign_user->save();
        }elseif (isset($company) && auth()->user()->class == 'cp') {
            $company = Company::findOrFail(auth()->user()->id);
            $company->location = $request->location;
            $status = $company->save();
        }

        if ($status) {
            return redirect()->back()->with('success','Editado com sucesso');
        }else {
            return redirect()->back()->with('fail','Algo deu errado, dados não editado');
        }
        
    }
    
    
}