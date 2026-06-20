<?php

namespace App\Http\Controllers;

use App\Models\Notificacao;
use App\Services\Notificacao\NotificacaoService;
use Illuminate\Http\Request;

class NotificacaoController extends Controller
{
   private $oNotificacaoService;

    public function __construct(NotificacaoService $notificacaoService){
        $this->oNotificacaoService = $notificacaoService;
    }
    
    public function getNotificacoes(Request $request){
        return $this->oNotificacaoService->getNotificacoes($request);
    }

    public function lerNotificacao(Notificacao $notificacao){
        return $this->oNotificacaoService->lerNotificacaoUsuario($notificacao);
    }

    public function lerTodasNotificacoes(Request $request){
        return $this->oNotificacaoService->lerTodasNotificacoesUsuario($request->user()->id);
    }

    public function removerNotificacao(Notificacao $notificacao){
        return $this->oNotificacaoService->removerNotificacao($notificacao);
    }
}