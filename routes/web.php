<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientAuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DiscountCodeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\TshirtController;
use App\Http\Controllers\TypeCategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', [HomeController::class,'login'])->name('login');
Route::post('/login', [HomeController::class,'post_login'])->name('post_login');
Route::get('/carts', [HomeController::class,'cart'])->name('cart');

Route::post('/client_login', [HomeController::class,'client_login'])->name('client_login');


Route::get('/', [HomeController::class,'welcom'])->name('home');
Route::get('showProduct/{id}',[HomeController::class, 'showProduct'])->name('showProduct');
Route::get('/shirts', [HomeController::class, 'getShirts']);
Route::get('/get-color-image', [HomeController::class, 'getColorImage'])->name('color_image');

Route::post('/save-design', [HomeController::class, 'saveDesign']);
Route::get('get_image_session', [HomeController::class, 'get_image_session']);
Route::get('get-design', [HomeController::class, 'get_design']);
Route::get('get-design-preview', [HomeController::class, 'get_design_preview']);
Route::post('/save-shirt-image', [HomeController::class, 'saveShirtImage']);
Route::get('check_temp', [HomeController::class, 'check_temp']);
Route::get('/peconfirm-order', [HomeController::class, 'confirm_order']);
Route::get('/updateCart', [HomeController::class, 'updateCart']);
Route::get('/removeCart', [HomeController::class, 'removeCart']);
Route::get('/check-cart', [HomeController::class, 'checkCart']);


Route::post('/favorite/{id}', [HomeController::class, 'toggleFavorite'])->name('toggleFavorite');




Route::get('3d',function(){
    return view('front.3d');
});
Route::get('client-login',function(){
    return view('front.login');
});

Route::group(['prefix' => 'client'], function () {
    Route::get('login', [ClientAuthController::class, 'showLoginForm'])->name('client.login');
    Route::get('register', [ClientAuthController::class, 'showRegisterForm'])->name('client.register');
    Route::post('login', [ClientAuthController::class, 'login'])->name('client.login.post');
    Route::post( 'register', [ClientAuthController::class, 'register'])->name('client.register.post');

   
    Route::post('logout', [ClientAuthController::class, 'logout'])->name('client.logout');
    
    // Add a middleware for client protection
    Route::middleware('auth:client')->group(function () {
        Route::get('/', [ClientController::class, 'index'])->name('client.dashboard');

        Route::get('dashboard', [ClientController::class, 'index'])->name('client.dashboard');
        Route::get('wishlist', [ClientController::class, 'wishlist'])->name('client.wishlist');

    });
    Route::post('update-profile', [ClientController::class, 'updateProfile'])->name('client.profile.update');

});

Route::group(['middleware' => ['auth'], 'prefix' => 'dashboard'], function () {
Route::get('/', action: [HomeController::class,'home'])->name('dashboard');

Route::post('add_general', [HomeController::class, 'add_general'])->name('add_general');
Route::get('setting', [HomeController::class, 'setting'])->name('setting');
Route::get('shopping', [HomeController::class, 'shopping'])->name('shopping');

Route::get('logout', [HomeController::class, 'logout'])->name('logout');
Route::get('edit_profile', [HomeController::class, 'edit_profile'])->name('edit_profile');
Route::post('edit_profile',[HomeController::class, 'edit_profile_post'])->name('edit_profile_post');
Route::get('language_translate/{local}',[HomeController::class,'show_translate'])->name('show_translate');
Route::post('/languages/key_value_store',[HomeController::class,'key_value_store'])->name('languages.key_value_store');
Route::get('change_lang/{id}',[HomeController::class,'change_lang'])->name('change_lang');
Route::resource('products',ProductController::class);
Route::resource('customers',CustomerController::class);
Route::post('customer/{id}/edit',[CustomerController::class,'update'])->name('customer.updated');

Route::resource('colors',ColorController::class);
Route::resource('sizes',SizeController::class);
Route::resource('categories',controller: CategoryController::class);
Route::resource('subcategories',controller: SubCategoryController::class);
Route::get('/get-subcategories/{category_id}', [ProductController::class, 'getSubcategories'])->name('get.subcategories');
Route::get('/get_deteitls_subcategories/{category_id}', [SubCategoryController::class, 'get_deteitls_subcategories'])->name('get_deteitls_subcategories');


Route::get('main_categories',[CategoryController::class,'index'])->name('main_categories');
Route::get('cats',[CategoryController::class,'index_cat'])->name('index_cat');
Route::get('create_cat',[CategoryController::class,'create_cat'])->name('create_cat');


Route::resource('types',TypeCategoryController::class);

Route::resource('discountcode',DiscountCodeController::class);


Route::get('tshirt_create',[ProductController::class,'tshirt_create'])->name('tshirt_create');
Route::get('pen_create',[ProductController::class,'pen_create'])->name('pen_create');
Route::get('tshirt_index',[ProductController::class,'tshirt_index'])->name('tshirt_index');
Route::get('pen_index',[ProductController::class,'pen_index'])->name('pen_index');






});



