<?php

namespace App\Http\Controllers;

use App\Services\Notificacao\NotificacaoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotificacaoController extends Controller
{
   private $oNotificacaoService;

    public function __construct(NotificacaoService $notificacaoService){
        $this->oNotificacaoService = $notificacaoService;
    }
    
    public function getNotificacoes(Request $request){
        return $this->oNotificacaoService->getNotificacoes($request);
    }
}