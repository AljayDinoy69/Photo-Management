<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AuthenticateController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ConfirmPasswordController;

Route::middleware('guest')->group(function() {

//Register

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

//Login

Route::get('/login', [AuthenticateController::class, 'create'])->name('login');
Route::post('/login', [AuthenticateController::class, 'store']);
});

//Reset
Route::get('/forgot-password', [ResetPasswordController::class, 'forgot'])->name('password.request');
Route::post('/forgot-password', [ResetPasswordController::class, 'send'])->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'reset'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'update'])->name('password.update');

Route::middleware('auth')->group(function() {

//Logout
Route::post('/logout', [AuthenticateController::class, 'destroy'])->name('logout');

//Email Verification
Route::get('email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');

Route::get('email/verify/{id}/{hash}', [EmailVerificationController::class, 'handler'])->middleware('signed')->name('verification.verify');

Route::post('email/verification-notification', [EmailVerificationController::class, 'resend'])->middleware(['throttle:6,1'])->name('verification.send');

//Password Confirmation
Route::get('/confirm-password', [ConfirmPasswordController::class, 'create'])->name('password.confirm');
Route::post('/confirm-password', [ConfirmPasswordController::class, 'store'])->middleware('throttle:6,1');
});