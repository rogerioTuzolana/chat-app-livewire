<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Account\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChatController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



//Route::get('/login', [AuthController::class, 'index']);
Route::middleware(['PreventBackHistory'])->group(function(){

    Route::get('/login', [UserController::class, 'login'])->name('login');
    Route::post('/login', [UserController::class, 'auth'])->name('auth');

    Route::get('/register', [UserController::class, 'register'])->name('register');
    Route::post('/register', [UserController::class, 'create'])->name('create');

    Route::post('/esqueci-senha', [UserController::class, 'forgot_password'])->name('esqueci-senha');
    Route::get('/recuperar-senha/{token}', [UserController::class, 'recover_password'])->name('recuperar-senha');
    Route::put('/trocar-senha', [UserController::class, 'change_password'])->name('mudar-senha');

});


Route::group(['prefix' => 'conta','middleware'=>['auth','user','PreventBackHistory']], function () {
    Route::get('/', [UserController::class, 'index'])->name('home');
    Route::get('/lista-utilizadores', [ProfileController::class, 'list_users'])->name('list');
    Route::get('/chat/{user_id}',[ChatController::class,'index'])->name('chat');
    //Route::get('/chat',[ChatController::class,'index'])->name('meeting');
    
    Route::get('/mensagens', [ProfileController::class, 'messages'])->name('messages');

    //post,put
    Route::put('/ver-notificacao', [ProfileController::class, 'view_notification'])->name('ver-notificacao');

    
    Route::post('/enviar-mensagemParaCompra', [ProfileController::class, 'sendMessageBuy'])->name('enviar-mensagemParaCompra');
    
    Route::post('/logout', [UserController::class, 'logout'])->middleware(['auth'])->name('logout');

});
