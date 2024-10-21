<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Users\LoginController;

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
Route::get('admin/users/login', [LoginController::class, 'index'])->name('login');
Route::post('admin/users/login/store', [LoginController::class, 'store']);

Route::get('signout', [LoginController::class, 'signOut'])->name('signout');
Route::get('admin/users/register', [LoginController::class, 'indexRegister'])->name('indexRegister');
Route::post('admin/users/register', [LoginController::class, 'register'])->name('register');


Route::get('admin/users/forget-password', [LoginController::class, 'forgetPassword'])->name('forgetPassword'); //Hien thi form quen mat khau
Route::post('admin/users/forget-password', [LoginController::class, 'postForgetPass'])->name('postForgetPass'); // khi submit quen mat khau
Route::get('admin/users/get-password', [LoginController::class, 'getPassword'])->name('getPassword');    // gui link
Route::get('admin/users/get-password/{customer}/{token}', [LoginController::class, 'postGetPassword']);    // nhap lai mat khau 2 lan
