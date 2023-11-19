<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserGroupController;

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
Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'loginPost'])->name('login.post');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

// register
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register', [UserController::class, 'registerPost'])->name('register.post');

// profil
Route::get('/profile', [UserController::class, 'profile'])->name('profile');
Route::post('/profile', [UserController::class, 'profilePost'])->name('profile.post');

// users
Route::get('/users', [UserController::class, 'users'])->name('users');
Route::get('/users/{id}', [UserController::class, 'user'])->name('user');
Route::post('/users/delete/{id}', [UserController::class, 'userDelete'])->name('user.delete');

// groups
Route::get('/groups', [UserGroupController::class, 'groups'])->name('groups');
Route::get('/groups/create', [UserGroupController::class, 'groupCreate'])->name('group.create');
Route::post('/groups/create', [UserGroupController::class, 'groupCreatePost'])->name('group.create.post');
Route::get('/groups/{id}', [UserGroupController::class, 'group'])->name('group');
