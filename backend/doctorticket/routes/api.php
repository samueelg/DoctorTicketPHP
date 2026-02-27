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
Route::middleware('auth:sanctum')->get('/usuarios', [UsuarioController::class, 'getUsuarios'])->name('usuarios');
Route::middleware('auth:sanctum')->get('/usuarios/{user}', [UsuarioController::class, 'getUsuario'])->name('usuarios');
Route::middleware('auth:sanctum')->post('/usuarios', [UsuarioController::class, 'saveUsuario'])->name('usuarios.create');
Route::middleware('auth:sanctum')->patch('/usuarios/{user}', [UsuarioController::class, 'editUsuario'])->name('usuarios.edit');
Route::middleware('auth:sanctum')->delete('/usuarios/{user}', [UsuarioController::class, 'removeUsuario'])->name('usuarios.delete');
