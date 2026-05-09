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
    public function getRelatorioTicketsChats(Request $filtros){
        $mockFilter = [
            'data' => '2026-01-01',
            'solicitante' => 'Samuel',
        ];

        $tickets = $this->oRelatorioService->getTicketsChat($mockFilter);
        
        return $tickets;
    }
}
