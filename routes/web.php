<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
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

// Home page
Route::get('/', [UserController::class, 'front_page'])->name('/');

// Show the signup page (GET request)
Route::get('/signup', [UserController::class, 'signup_page'])->name('signup');

// Handle the signup form submission (POST request)
Route::post('/signup', [UserController::class, 'signup'])->name('submit.signup'); 

// Show the login page (GET request)
Route::get('/login', [UserController::class, 'login_page'])->name('login');

// Handle the login form submission (POST request)
Route::post('/home', [UserController::class, 'login'])->name('submit.login'); 

// Logout route
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// Home page after login
Route::get('/home', [UserController::class, 'home_page'])->name('home');

// route for creating post
Route::post('/post', [PostController::class, 'postCreatePost'])->name('post.create');

// route for getting/retrieving all the post
Route::get('/fetch-data', [PostController::class, 'fetchPosts']);

// route for retrieving all the comments on specific post
Route::get('/post/{post}/comments', [PostController::class, 'fetchComments']);

// route for creating a post
Route::get('/post/{post_id}/submitComment', [PostController::class, 'createComment']);

// route for retrieving post data
Route::get('/post/{post_id}/postData', [PostController::class, 'retrievePostData']);

// route for editing post
Route::post('/post/{post_id}/editPost', [PostController::class, 'editPostCaption']);

// route for retrieving the comment data
Route::get('/comment/{comment_id}/data', [PostController::class, 'editCommentBTN']);

// route for editing the comment
Route::post('/comment/{comment_id}/edit', [PostController::class, 'editComment']);