<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\testController;


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

Route::get('/', function () {
    return view('welcome');
});
Route::get('handy', [testController::class, 'handy'])->name('handy');
Route::post('create', [testController::class, 'store'])->name('create');
// Route::group(['prefix' => 'api'],function(){
//     Route::get('list', [UserController::class, ''])->name('api.category');
// });

