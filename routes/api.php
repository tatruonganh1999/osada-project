<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\SloganController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\NewsController;


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::get('profile', [AuthController::class, 'profile']);
    Route::put('profileUpdate', [AuthController::class, 'profileUpdate']);
    Route::post('logout', [AuthController::class, 'logout']);
    // Route::get('bannerList', [BannerController::class,'bannerList']);

    // Route::post('logout', [AuthController::class, 'logout']);
    // Route::get("profile", [AuthController::class, "profile"]);
    // Route::post('login', 'AuthController@login');
    // Route::post('logout', 'AuthController@logout');
    // Route::post('refresh', 'AuthController@refresh');
    // Route::post('me', 'AuthController@me');
    // Route::get('userList', [UserController::class, 'userList']);

});
// Route::group(['prefix'=>'admin','namespace'=>'App\Http\Controller\Admin'],function(){
//     Route::get('users',UserController::class);
// });
Route::middleware(['auth:api', 'role:1'])->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('userList', 'userList')->middleware('jwt.check');
        Route::post('userCreate', 'userCreate')->middleware('jwt.check');
        Route::get('userDetail/{id}', 'userDetail')->middleware('jwt.check');
        Route::put('userUpdate/{id}', 'userUpdate')->middleware('jwt.check');
        Route::put('userDelete/{id}', 'userDelete')->middleware('jwt.check');
        Route::put('changePassword', 'changePassword')->middleware('jwt.check');
    });
});

Route::controller(BannerController::class)->group(function () {
    Route::get('bannerList', 'bannerList');
    Route::post('bannerCreate', 'bannerCreate');
    Route::put('bannerUpdate/{id}', 'bannerUpdate');
    Route::put('bannerDelete/{id}', 'bannerDelete');
});

Route::controller(SloganController::class)->group(function () {
        Route::get('sloganList', 'sloganList');
        Route::post('sloganCreate', 'sloganCreate');
        Route::put('sloganUpdate/{id}', 'sloganUpdate');
        Route::put('sloganDelete/{id}', 'sloganDelete');
});

Route::controller(CategoryController::class)->group(function () {
    Route::get('categoryList', 'categoryList');
    Route::post('categoryCreate', 'categoryCreate');
    Route::put('categoryUpdate/{id}', 'categoryUpdate');
    Route::put('categoryDelete/{id}', 'categoryDelete');
});

Route::controller(ProductController::class)->group(function () {
    Route::get('productList', 'productList');
    Route::post('productCreate', 'productCreate');
    Route::put('productUpdate/{id}', 'productUpdate');
    Route::put('productDelete/{id}', 'productDelete');
});

// Route::middleware(['auth:api', 'role:1'])->group(function () {
    Route::controller(NewsController::class)->group(function () {
        Route::get('newsList', 'newsList');
        Route::post('newsCreate', 'newsCreate');
        Route::put('newsUpdate/{id}', 'newsUpdate');
        Route::put('newsDelete/{id}', 'newsDelete');
    });
// });