<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::view('/login-with-otp','auth.loginwithotp')->name('login.with.otp');
Route::post('/login-with-otp-post',[App\Http\Controllers\OTPController::class, 'loginwithoptpost'])->name('login.with.otp.post');
Route::view('/confirm-login-with-otp','auth.confirmloginwithotp')->name('confirm.login.with.otp');
Route::post('/confirm-login-with-otp-post',[App\Http\Controllers\OTPController::class, 'confirmloginwithoptpost'])->name('confirm.login.with.otp.post');

