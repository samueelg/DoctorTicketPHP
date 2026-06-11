<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveTicketRequest;
use App\Models\Ticket;
use App\Services\Notificacao\NotificacaoService;
use App\Services\Processamento\ProcessamentoService;
use App\Services\Transcricao\TranscricaoService;
use Exception;

class TicketController extends Controller
{
    private $oProcessamentoService;
    private $oTranscricaoService;
    private $oNotificacaoService;

    public function __construct(TranscricaoService $transcricaoService, ProcessamentoService $processamentoService, NotificacaoService $notificacaoService)
    {
        $this->oTranscricaoService   = $transcricaoService;
        $this->oProcessamentoService = $processamentoService;
        $this->oNotificacaoService   = $notificacaoService;
    }

    public function finalizaLigacao(){
        $audio = request()->file('audio');

        $transcricao = $this->oTranscricaoService->transcrever($audio);

        $processamento = $this->oProcessamentoService->processarDados($transcricao);

        return $processamento;
    }

    public function salvarTicket(SaveTicketRequest $request){
        try{
            $dataAtual = now()->format('Y-m-d H:i:s');

            $ticket = Ticket::create([
                'titulo' => $request->titulo,
                'assunto' => $request->assunto,
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

    public function criaNotificacao(){
        $this->oNotificacaoService->criarNotificacao();

        return response()->json(['message' => 'Sucesso!']);
    }

}
