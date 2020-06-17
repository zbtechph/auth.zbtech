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

Route::namespace('Auth')->prefix('auth')->name('auth.')->group(function(){
    Route::get('login', "LoginController@showForm")->name('login');
    Route::post('login', "LoginController@authenticate")->name('authenticate');
    Route::post('logout', "LoginController@logout")->name('logout');
    Route::get('register', "RegisterController@showForm")->name('register');
    Route::post('register', "RegisterController@attemptRegister")->name("attemptRegister");
});

Route::redirect('/login', "auth/login")->name('login');

Route::get('/', function () {
    return view('welcome');
});
