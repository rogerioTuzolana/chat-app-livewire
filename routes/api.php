<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Account\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\api\UserProfileController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::get('/test', [UserProfileController::class, 'test'])->name('test');

//Route::middleware(['guest'])->group(function(){
    Route::get('/login', [UserProfileController::class, 'authentication'])->name('login');
//});

Route::group(['middleware'=>['apiuser']], function () {
    Route::get('/test1', function(){
        return response()->json([
            "text"=>"Yes",
        ],200);
    })->name('test1');
    
});