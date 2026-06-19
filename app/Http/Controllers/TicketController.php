<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveTicketRequest;
use App\Models\Franqueado;
use App\Models\Ticket;
use App\Services\Ligacao\LigacaoService;
use App\Services\Notificacao\NotificacaoService;
use App\Services\Processamento\ProcessamentoService;
use App\Services\Transcricao\TranscricaoService;
use App\Services\Movidesk\MovideskService;
use Illuminate\Support\Facades\Log;

use Exception;

class TicketController extends Controller
{
    private $oProcessamentoService;
    private $oTranscricaoService;
    private $oNotificacaoService;
    private $oMovideskService;
    private $oLigacaoService;

    public function __construct(TranscricaoService $transcricaoService, ProcessamentoService $processamentoService, NotificacaoService $notificacaoService, MovideskService $movideskService, LigacaoService $ligacaoService)
    {
        $this->oTranscricaoService   = $transcricaoService;
        $this->oProcessamentoService = $processamentoService;
        $this->oNotificacaoService   = $notificacaoService;
        $this->oMovideskService      = $movideskService;
        $this->oLigacaoService       = $ligacaoService;
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
            $franqueado = Franqueado::where('idMovidesk', $request->solicitante)->first();

            $ticket = Ticket::create([
                'titulo' => $request->titulo,
                'assunto' => $request->assunto,
                'data_conclusao' => $dataAtual,
                'status' => $request->status,
                'idUsuario' => $request->user()->id,
                'categoria' => $request->categoria,
                'solicitante' => $franqueado->id,
                'urgencia' => $request->urgencia,
            ]);

            $dadosLigacao = [
                'idUsuario'    => $request->user()->id,
                'idFranqueado' => $franqueado->id
            ];

            $ligacao  = $this->oLigacaoService->salvaLigacao($dadosLigacao);
            $movidesk = $this->oMovideskService->salvaTicketMovidesk($request);

                return response()->json([
                    'message' => 'Ticket criado com sucesso',
                    'data' => [
                        'idTicket' => $ticket->id,
                        'idLigacao' => $ligacao->id
                    ],
                ], 201);


        }catch(Exception $e){
            try {
                Log::error($e->getMessage());
                Log::error($e->getTraceAsString());
            } catch (\Throwable) {
                // Evita que uma falha de logging mascare a exceção original e gere um 500 sem corpo
            }

            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function criaNotificacao(){
        $this->oNotificacaoService->criarNotificacao();

        return response()->json(['message' => 'Sucesso!']);
    }

}
