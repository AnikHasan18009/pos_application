<?php

use App\Http\Middleware\TokenVerifyMiddleware;
use App\Mail\OTPMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TokenController;

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



Route::post('/user-registration', [UserController::class,'userRegistration']);
Route::post('/user-login', [UserController::class,'userLogin']);

Route::post("/send-otp",[UserController::class,'sendOTP']);
Route::post("/verify-otp",[UserController::class,'verifyOTP']);

Route::post("/reset-password",[UserController::class,'resetPassword'])->middleware([TokenVerifyMiddleware::class]);