<?php

namespace App\Http\Controllers;

use App\Services\Exportacao\Factories\ExportacaoFactory;
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
    public function getRelatorio(Request $request){
        $filtros = $request->all();
        
        $tickets = [];
        switch($filtros['filtro']){
            case 1:
                $tickets = $this->oRelatorioService->getTicketsChat($filtros);
                break;
        }
        
        return $tickets;
    }

    public function geraArquivoExportacao(Request $request){
        $dados = $this->getRelatorio($request);
        $tipo = $request->tipo;

        $provider = ExportacaoFactory::criar($tipo);
        return $provider->exportar($dados);
        
    }
}
