<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GroupController;


Route::get('/register', [UserController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [UserController::class, 'register'])
    ->name('register.store');


Route::get('/login', [UserController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [UserController::class, 'login'])
    ->name('login.store');


Route::post('/logout', [UserController::class, 'logout'])
    ->name('logout');

Route::get('/dashboard', [UserController::class, 'teacherDashboard'])
    ->middleware('auth')
    ->name('dashboard');

Route::get('/groups/create', [GroupController::class, 'create'])
    ->middleware('auth')
    ->name('groups.create');

Route::post('/groups', [GroupController::class, 'store'])
    ->middleware('auth')
    ->name('groups.store');


// Admin Dashboard
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
    ->middleware('auth')
    ->name('admin.dashboard');

    // Admin - Teachers
Route::get('/admin/teachers/{id}/edit', [AdminController::class, 'editTeacher'])
    ->middleware('auth')
    ->name('admin.teachers.edit');

Route::put('/admin/teachers/{id}', [AdminController::class, 'updateTeacher'])
    ->middleware('auth')
    ->name('admin.teachers.update');

Route::delete('/admin/teachers/{id}', [AdminController::class, 'deleteTeacher'])
    ->middleware('auth')
    ->name('admin.teachers.delete');

// Admin - Groups
Route::get('/admin/groups/{id}/edit', [AdminController::class, 'editGroup'])
    ->middleware('auth')
    ->name('admin.groups.edit');

Route::put('/admin/groups/{id}', [AdminController::class, 'updateGroup'])
    ->middleware('auth')
    ->name('admin.groups.update');

Route::delete('/admin/groups/{id}', [AdminController::class, 'deleteGroup'])
    ->middleware('auth')
    ->name('admin.groups.delete');
// Teacher - Groups
Route::get('/teacher/groups/{id}/edit', [UserController::class, 'editGroup'])
    ->middleware('auth')
    ->name('teacher.groups.edit');

Route::put('/groups/{id}', [UserController::class, 'updateGroup'])
    ->middleware('auth')
    ->name('groups.update');

Route::delete('/teacher/groups/{id}', [UserController::class, 'deleteGroup'])
    ->middleware('auth')
    ->name('teacher.groups.delete');