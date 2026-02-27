<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

/* Rotas de Autenticação */
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

/* Rotas de Usuários */
Route::get('/usuarios', [UsuarioController::class, 'getUsuarios'])->name('usuarios');
Route::post('/usuarios/create', [UsuarioController::class, 'saveUsuario'])->name('usuarios.create');
Route::post('/usuarios/edit/{user}', [UsuarioController::class, 'editUsuario'])->name('usuarios.edit');
Route::delete('/usuarios/delete/{user}', [UsuarioController::class, 'removeUsuario'])->name('usuarios.delete');
