<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['middleware' => ['auth:admin']], function(){
    Route::get('/home/admin', [App\Http\Controllers\HomeController::class, 'adminHome'])->name('home.admin');
});

Route::group(['middleware' => ['auth:provider']], function(){
    Route::get('/home/provider', [App\Http\Controllers\HomeController::class, 'providerHome'])->name('home.provider');
});

Route::group(['middleware' => ['guest:admin']], function(){
    Route::get('/login/admin', [App\Http\Controllers\Auth\LoginController::class, 'showAdminLoginForm']);
    Route::post('/login/admin', [App\Http\Controllers\Auth\LoginController::class, 'adminLogin'])->name('admin.login');
});


Route::group(['middleware' => ['guest:provider']], function(){
    Route::get('/login/provider', [App\Http\Controllers\Auth\LoginController::class, 'showProviderLoginForm']);
    Route::post('/login/provider', [App\Http\Controllers\Auth\LoginController::class, 'providerLogin'])->name('provider.login');
});