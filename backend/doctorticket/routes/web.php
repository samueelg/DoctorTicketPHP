<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\HomeController;


Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/list', [UsuarioController::class, 'getUsuariosView'])->name('usersList');
Route::get('/create', [UsuarioController::class, 'getCreateUserView'])->name('createUser');
Route::post('/createUser', [UsuarioController::class, 'saveUsuario'])->name('createUserSubmit');
Route::get('/edit/{user}', [UsuarioController::class, 'getEditView'])->name('editUser');
Route::post('/edit/{user}', [UsuarioController::class, 'editUsuario'])->name('editUserSubmit');
Route::delete('/delete/{user}', [UsuarioController::class, 'removeUsuario'])->name('deleteUserSubmit');
