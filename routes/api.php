<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FranqueadoController;
use App\Http\Controllers\NotificacaoController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UnidadeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

/* Rotas de Autenticação */
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

/* Rotas de Usuários */
Route::middleware('auth:sanctum')->get('/me', [UsuarioController::class, 'getDadosUsuario'])->name('me');
Route::middleware('auth:sanctum')->get('/usuarios', [UsuarioController::class, 'getUsuarios'])->name('usuarios');
Route::middleware('auth:sanctum')->get('/usuarios/{user}', [UsuarioController::class, 'getUsuario'])->name('usuarios');
Route::middleware('auth:sanctum')->post('/usuarios', [UsuarioController::class, 'salvarUsuario'])->name('usuarios.create');
Route::middleware('auth:sanctum')->patch('/usuarios/{user}', [UsuarioController::class, 'editarUsuario'])->name('usuarios.edit');
Route::middleware('auth:sanctum')->delete('/usuarios/{user}', [UsuarioController::class, 'removerUsuario'])->name('usuarios.delete');

/* Rotas de Configuracao de Usuários */
Route::middleware('auth:sanctum')->post('/configuracao/{user}', [UsuarioController::class, 'salvarConfiguracao'])->name('usuarios.salvarConfiguracao');

/* Rotas de Ticket */
Route::middleware('auth:sanctum')->post('/ticket', [TicketController::class, 'salvarTicket'])->name('ticket.create');

/* Rotas de notificação */
Route::middleware('auth:sanctum')->post('/notificacao', [TicketController::class, 'criaNotificacao'])->name('notificacao.criar');
Route::middleware('auth:sanctum')->get('/notificacao', [NotificacaoController::class, 'getNotificacoes'])->name('notificacao.get');
Route::middleware('auth:sanctum')->patch('/notificacao/{notificacao}', [NotificacaoController::class, 'lerNotificacao'])->name('notificacao.patch');
Route::middleware('auth:sanctum')->delete('/notificacao/{notificacao}', [NotificacaoController::class, 'removerNotificacao'])->name('notificacao.delete');

/* Rotas de transcrição*/
Route::middleware('auth:sanctum')->post('/transcrever', [TicketController::class, 'finalizaLigacao'])->name('finalizaLigacao');

/* Rotas de relatórios */
Route::middleware('auth:sanctum')->get('/relatorio', [RelatorioController::class, 'getRelatorio'])->name('relatorio.get');
Route::middleware('auth:sanctum')->get('/relatorios/exportarRelatorio', [RelatorioController::class, 'geraArquivoExportacao'])->name('relatorios.exportar');
Route::middleware('auth:sanctum')->get('/relatorios/download/{arquivo}', [RelatorioController::class, 'download'])->name('relatorios.download');

/* Rotas de franqueado */
Route::middleware('auth:sanctum')->get('/franqueado', [FranqueadoController::class, 'getFranqueado'])->name('franqueado.get');

/* Rotas de Unidade */
Route::middleware('auth:sanctum')->get('/unidade', [UnidadeController::class, 'getUnidades'])->name('unidades.get');
