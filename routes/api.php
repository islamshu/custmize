<?php

use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\UserController;
use App\Services\UnsplashService;
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

Route::middleware(['cors'])->group(function () {

Route::get('products',[HomeController::class,'products']);
Route::get('home',[HomeController::class,'home']);

Route::get('get_single_product/{slug}',[HomeController::class,'single_product'])->name('get_single_product');
Route::post('login',[UserController::class,'login']);
Route::post('register',[UserController::class,'register']);
Route::post('verify_otp',[UserController::class,'verify_otp']);
Route::post('forgotPassword',[UserController::class,'forgotPassword']);
Route::post('password_reset',[UserController::class,'resetPassword'])->name('password_reset');
Route::get('size_calculate',[HomeController::class,'size_calculate'])->name('size_calculate');
Route::get('example_size_calculate',[HomeController::class,'example_size_calculate'])->name('size_calculate');
Route::get('size_calculate_new',[HomeController::class,'size_calculate_new'])->name('size_calculate_new');
Route::get('size_calculate_new_factor',[HomeController::class,'size_calculate_new_factor'])->name('size_calculate_new_factor');


Route::get('libraray', [HomeController::class,'images'])->name('images');
Route::post('checkout_guest',[CheckoutController::class,'initiatePayment_guest'])->name('checkout');
Route::get('track_order',[HomeController::class,'track_order']);

Route::middleware(['auth:api', 'is_login'])->group(function () {
    Route::get('myprofile',[UserController::class,'myprofile']);
    Route::post('update_profile',[UserController::class,'update_profile'])->name('update_profile');
    Route::post('checkout',[CheckoutController::class,'initiatePayment'])->name('checkout');

    Route::post('check_promocode',[UserController::class,'check_promocode'])->name('check_promocode');
    Route::get('all_promocods',[HomeController::class,'all_promocods']);
    Route::get('all_orders',[HomeController::class,'all_orders']);

    
});
});
