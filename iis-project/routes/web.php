<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserGroupController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\PostController;

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


Route::post('/groups/join-request/{id}', [UserGroupController::class, 'joinRequest'])->name('group.join.request');
Route::get('/request-list', [UserGroupController::class, 'requestList'])->name('request.list');
Route::post('/groups/{groupId}/join-approve{userId}', [UserGroupController::class, 'joinApprove'])->name('group.join.approve');
Route::post('/groups/{groupId}/join-decline{userId}', [UserGroupController::class, 'joinDecline'])->name('group.join.decline');
Route::post('/groups/{groupId}/kick{userId}', [UserGroupController::class, 'kick'])->name('group.kick');
Route::post('/groups/{id}/leave', [UserGroupController::class, 'leave'])->name('group.leave');

Route::post('/groups/role-request/{id}', [UserGroupController::class, 'roleRequest'])->name('group.role.request');
Route::post('/groups/{groupId}/role-approve{userId}', [UserGroupController::class, 'roleApprove'])->name('group.role.approve');
Route::post('/groups/{groupId}/role-decline{userId}', [UserGroupController::class, 'roleDecline'])->name('group.role.decline');
Route::post('/groups/{groupId}/role-derank{userId}', [UserGroupController::class, 'roleDerank'])->name('group.role.derank');

// threads
Route::get('/threads/{groupId}', [ThreadController::class, 'threads'])->name('threads');
Route::get('/thread/create/{groupId}', [ThreadController::class, 'threadCreate'])->name('thread.create');
Route::post('/thread/create/{groupId}', [ThreadController::class, 'threadCreatePost'])->name('thread.create.post');
Route::post('/thread/delete/{id}', [ThreadController::class, 'delete'])->name('thread.delete');

// posts
Route::get('/posts/{id}', [PostController::class, 'posts'])->name('posts');
Route::get('/post/create/{id}', [PostController::class, 'postCreate'])->name('post.create');
Route::post('/post/create/{id}', [PostController::class, 'postCreatePost'])->name('post.create.post');
Route::post('/post/delete/{id}', [PostController::class, 'postDelete'])->name('post.delete');

// ratings
Route::post('/like/{id}', [PostController::class, 'like'])->name('like');
Route::post('/dislike/{id}', [PostController::class, 'dislike'])->name('dislike');
