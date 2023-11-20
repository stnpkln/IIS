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
Route::get('/my-groups', [UserGroupController::class, 'myGroups'])->name('groups.me');
Route::get('/group/{id}', [UserGroupController::class, 'group'])->name('group');
Route::get('/groups/create', [UserGroupController::class, 'groupCreate'])->name('group.create');
Route::post('/groups/create', [UserGroupController::class, 'groupCreatePost'])->name('group.create.post');
Route::post('/groups/delete/{id}', [UserGroupController::class, 'delete'])->name('group.delete');
Route::get('/groups/edit/{id}', [UserGroupController::class, 'edit'])->name('group.edit');
Route::post('/groups/edit/{id}', [UserGroupController::class, 'editPost'])->name('group.edit.post');

Route::get('/groups/threads/{id}', [UserGroupController::class, 'threads'])->name('group.threads');

Route::post('/groups/join-request/{id}', [UserGroupController::class, 'joinRequest'])->name('group.join.request');
Route::get('/request-list', [UserGroupController::class, 'requestList'])->name('request.list');
Route::post('/groups/{groupId}/join-approve{userId}', [UserGroupController::class, 'joinApprove'])->name('group.join.approve');
Route::post('/groups/{groupId}/join-decline{userId}', [UserGroupController::class, 'joinDecline'])->name('group.join.decline');
Route::post('/groups/{groupId}/kick{userId}', [UserGroupController::class, 'kick'])->name('group.kick');
Route::post('/groups/{id}/leave', [UserGroupController::class, 'leave'])->name('group.leave');