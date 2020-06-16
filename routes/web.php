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
    Route::get('login', "Login@showForm")->name('login');
    Route::post('login', "Login@authenticate")->name('authenticate');
    Route::get('register', "Register@showForm")->name('register');
    Route::post('register', "Register@attemptRegister")->name("attemptRegister");
});

Route::redirect('/login', "auth/login")->name('login');

Route::get('/', function () {
    return view('welcome');
});
