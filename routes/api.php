<?php

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\Auth\LoginOtpController;
use App\Http\Controllers\Api\Auth\PasswordResetController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register',[LoginOtpController::class,'register']);
Route::post('login',[LoginOtpController::class,'login']);
Route::post('/otplogin',[LoginOtpController::class,'loginwithotp']);
Route::post('/sendotp',[LoginOtpController::class,'sendOTP']);
Route::post('/verifyotp',[LoginOtpController::class,'verifyOtp']);
Route::post('/active',[LoginOtpController::class,'active']);
Route::post('/forgotpassword',[PasswordResetController::class,'forgot_password']);

Route::middleware('auth:sanctum')->group(function () {
   
    Route::post('/resetpassword',[PasswordResetController::class,'reset_password']);
    Route::post('/changepassword',[PasswordResetController::class,'change_password']);

    //logout,delete
    Route::get('/logoutuser',[LoginOtpController::class,'logout']);
    Route::get('/delete',[LoginOtpController::class,'deleteaccount']);

    //user
    Route::get('/getprofile',[UserController::class,'profile']);
    Route::post('/updateprofile',[UserController::class,'update']);
    
    //product
    Route::post('product',[ProductController::class,'index']);
    Route::get('product/details/{id}',[ProductController::class,'search']);

    //doctor
    Route::post('speciality',[DoctorController::class,'index']);
    Route::get('doctor/details/{id}',[DoctorController::class,'search']);

    Route::post('save/favourites',[UserController::class,'save_favourite']);
    Route::post('doctor/favourites',[UserController::class,'favourite_doctor']);
    Route::get('favourites',[UserController::class,'favourite_list']);
    Route::post('delete/favourites',[UserController::class,'delete_favourite']);

    //appointments
    Route::post('book',[AppointmentController::class,'book_appointment']);
});
