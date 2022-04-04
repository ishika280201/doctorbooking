<?php
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Backend\AppointmentController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\DoctorController;
use App\Http\Controllers\Backend\ImageController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
  
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
Route::get('clear', [SupportController::class,'clear_cache']);
Route::get('caches',[SupportController::class,'caches']);
Route::get('migrate',[SupportController::class,'migration']);
Route::get('seed',[SupportController::class,'seeding']);

Auth::routes();
// Route::post('register',[RegisterController::class,'create'])->name('register');
// Route::post('login',[LoginController::class,'login'])->name('login');
Route::get('admin/home',[HomeController::class,'adminHome'])->name('admin.home')->middleware('is_admin');
Route::get('logout',[LoginController::class,'logout'])->name('logout');

//category
//Route::post('categories/list',[CategoryController::class,'index'])->name('categories.list');
//Route::resource('categories',CategoryController::class);
Route::match(['get', 'post'], '/categories/list',[CategoryController::class,'index'])->name('categories.list');
Route::post('categories/add',[CategoryController::class,'create'])->name('categories.add');
// Route::post('categories/update',[CategoryController::class,'update'])->name('categories.update');
Route::get('categories/edit',[CategoryController::class,'edit'])->name('categories.edit');
Route::post('categories/update',[CategoryController::class,'update'])->name('categories.update');
Route::match(['get', 'post'], '/categories/{id}/edit',[CategoryController::class,'edit'])->name('categories.edit');
Route::get('/categories/destroy/{id}',[CategoryController::class,'destroy']);

//image
Route::post('addimage',[ImageController::class,'createproduct'])->name('image.upload');


//product
Route::match(['get', 'post'], '/product/list',[ProductController::class,'index'])->name('product.list');
Route::post('product/add',[ProductController::class,'create'])->name('product.add');
Route::get('product/edit',[ProductController::class,'edit'])->name('product.edit');
Route::post('product/update',[ProductController::class,'update'])->name('product.update');
Route::match(['get', 'post'], '/product/{id}/edit',[ProductController::class,'edit'])->name('product.edit');
Route::get('/product/destroy/{id}',[ProductController::class,'destroy']);


//doctor
Route::match(['get', 'post'], '/doctors/list',[DoctorController::class,'index'])->name('doctor.list');
Route::post('doctor/add',[DoctorController::class,'create'])->name('doctor.add');
Route::get('doctor/edit',[DoctorController::class,'edit'])->name('doctor.edit');
Route::post('doctor/update',[DoctorController::class,'update'])->name('doctor.update');
Route::match(['get', 'post'], '/doctor/{id}/edit',[DoctorController::class,'edit'])->name('doctor.edit');
Route::get('/doctor/destroy/{id}',[DoctorController::class,'destroy']);

//appointments
Route::match(['get', 'post'], '/appointments/list',[AppointmentController::class,'index'])->name('appointment.list');