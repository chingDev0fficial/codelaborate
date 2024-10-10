<?php

use App\Http\Controllers\UserController;
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

Route::get('/', [UserController::class, 'front_page'])->name('/');

Route::get('/signup', [UserController::class, 'signup_page'])->name('signup');

Route::get('/login', [UserController::class, 'login_page'])->name('login');

Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::post('/home', [UserController::class, 'login'])->name('submit.login');

Route::post('/signup', [UserController::class, 'signup'])->name('submit.signup')->middleware('auth');
