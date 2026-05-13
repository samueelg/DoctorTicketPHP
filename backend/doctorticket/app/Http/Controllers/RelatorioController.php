<?php

namespace App\Http\Controllers;

use App\Services\Relatorio\RelatorioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RelatorioController extends Controller
{
    private $oRelatorioService;
    public function __construct(RelatorioService $relatorioService)
    {
        $this->oRelatorioService = $relatorioService;
    }

    /* Relatório responsavel por extrair os ticket abertos por CHAT WhatsApp Business */
    public function getRelatorioTicketsChats(Request $request){
        $filtros = $request->all();
        Log::info('filtros: ', $filtros);
        
        $tickets = $this->oRelatorioService->getTicketsChat($filtros);
        
        return $tickets;
    }
}
