<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', [UserController::class, 'index'])->name('usersList');
Route::get('/create', [UserController::class, 'createUser'])->name('createUser');
Route::post('/createUser', [UserController::class, 'store'])->name('createUserSubmit');
