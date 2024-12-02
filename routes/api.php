<?php

use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('products',[HomeController::class,'products']);
Route::get('home',[HomeController::class,'home']);

Route::get('get_single_product/{slug}',[HomeController::class,'single_product'])->name('get_single_product');
Route::post('login',[UserController::class,'login']);
Route::post('register',[UserController::class,'register']);
Route::post('verify_otp',[UserController::class,'verify_otp']);
Route::post('forgotPassword',[UserController::class,'forgotPassword']);
Route::post('password_reset',[UserController::class,'resetPassword'])->name('password_reset');
Route::group(['middleware' => ['auth:api'],['middleware' => 'is_login']], function () {
    Route::get('myprofile',[UserController::class,'myprofile']);
    Route::post('update_profile',[UserController::class,'update_profile'])->name('update_profile');
});
