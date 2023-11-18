<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

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

// homepage
Route::get('/', function () {
    return view('homepage');
})->name('homepage');

// login
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'loginPost'])->name('login.post');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// register
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/register', [LoginController::class, 'registerPost'])->name('register.post');

// profil
Route::get('/profile', [LoginController::class, 'profile'])->name('profile');
Route::post('/profile', [LoginController::class, 'profilePost'])->name('profile.post');

// users
Route::get('/users', [LoginController::class, 'users'])->name('users');
Route::get('/users/{id}', [LoginController::class, 'user'])->name('user');