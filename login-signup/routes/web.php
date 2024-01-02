<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthManager;

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
    return view('login');
});

Route::get('/home', function () {
    return view('home');
}) -> name('home');

Route::get('/login', [AuthManager::class, 'login']) -> name('login');
Route::post('/login', [AuthManager::class, 'loginPost']) -> name('login_post');

Route::get('/signup', [AuthManager::class, 'signup']) -> name('signup');
Route::post('/signup', [AuthManager::class, 'signupPost']) -> name('signup_post');

Route::get('/logout', [AuthManager::class, 'logout']) -> name('logout');