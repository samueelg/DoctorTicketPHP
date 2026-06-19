<?php

namespace App\Http\Controllers;

use App\Jobs\GerarRelatorioJob;
use App\Services\Relatorio\RelatorioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RelatorioController extends Controller
{
    private RelatorioService $oRelatorioService;
    public function __construct(RelatorioService $relatorioService)
    {
        $this->oRelatorioService = $relatorioService;
    }

    public function getRelatorio(Request $request){
        return $this->oRelatorioService->getRelatorio($request->all());
    }

    public function geraArquivoExportacao(Request $request){
        GerarRelatorioJob::dispatch(
            $request->user()->id,
            $request->all()
        );

        return response()->json([
            'success' => true,
            'message' => 'Relatório em processamento'
        ]);
    }

    public function download(string $arquivo){
        $caminho = 'relatorios/' . basename($arquivo);

        abort_unless(
            Storage::disk('local')->exists($caminho),
            404,
            'Arquivo não encontrado'
        );

        return Storage::disk('local')->download($caminho);
    }
}
