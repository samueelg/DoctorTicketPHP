<?php

namespace App\Http\Controllers;

use App\Services\Processamento\ProcessamentoService;
use App\Services\Transcricao\TranscricaoService;

class TicketController extends Controller
{
    public function finalizaLigacao(TranscricaoService $transcricaoService, ProcessamentoService $processamentoService){
        $audioPath = public_path('audio/audio4.mp3');
        $transcricao = $transcricaoService->transcrever($audioPath);

        $processamento = $processamentoService->processarDados($transcricao);

        return $processamento;
    }

}
