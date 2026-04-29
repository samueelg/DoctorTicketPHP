<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveTicketRequest;
use App\Models\Ticket;
use App\Services\Processamento\ProcessamentoService;
use App\Services\Transcricao\TranscricaoService;
use Exception;
use Illuminate\Support\Facades\Request;

class TicketController extends Controller
{
    public function finalizaLigacao(TranscricaoService $transcricaoService, ProcessamentoService $processamentoService){
        $audioPath = public_path('audio/audio6.mp3');
        
        $transcricao = $transcricaoService->transcrever($audioPath);

        $processamento = $processamentoService->processarDados($transcricao);

        return $processamento;
    }

    public function salvarTicket(SaveTicketRequest $request){
        try{
            $dataAtual = now()->format('Y-m-d H:i:s');

            $ticket = Ticket::create([
                'titulo' => $request->titulo,
                'assunto' => $request->descricaoAssunto,
                'data_conclusao' => $dataAtual,
                'status' => $request->status,
                'idUsuario' => $request->user()->id,
                'categoria' => $request->categoria,
                'solicitante' => $request->solicitante,
                'urgencia' => $request->urgencia,
            ]);

            return response()->json([
                'message' => 'Ticket criado com sucesso',
                'data' => [
                    'id' => $ticket->id,
                ],
            ], 201);
        }catch(Exception $e){
            report($e);
            return response()->json([
                'message' => 'Erro ao criar ticket',
            ], 500);
        }
    }

}
