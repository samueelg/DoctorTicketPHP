<?php

namespace App\Services\Notificacao;

use App\Events\NotificacaoCriada;
use Illuminate\Support\Facades\Event;
use App\Models\Notificacao;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotificacaoService{
    public function criarNotificacao(){

    $notificacao = Notificacao::create([
        'idUsuario' => 1,
        'titulo' => 'Teste',
        'mensagem' => 'Websocket funcionando'
    ]);
    
    Event::dispatch(new NotificacaoCriada($notificacao));
    }

    public function getNotificacoes(Request $request){
        try{
        $notificacoes = Notificacao::where('idUsuario', $request->user()->id)
            ->get();

        $qtdeNaoLida = 0;

        forEach($notificacoes as $notificacao){
            if(!$notificacao->lida_em){
                $qtdeNaoLida++;
            }
        }

        return response()->json([
            'data' => $notificacoes,
            'qtdeNaoLida' => $qtdeNaoLida
        ]);
        }catch(Exception $e){
            Log::info(['Erro ao listar notificações! ' => $e]);

            return response()->json([
                'message' => $e,
                'success' => false
            ]);
        }
    }

    public function lerNotificacaoUsuario(Notificacao $notificacao){
        try{
            $notificacao->update([
                'lida_em'  => date('Y-m-d H:i:s'),
            ]);

            return response()->json([
                'message' => 'Notificação lida com sucesso',
                'success' => true,
                'data' => [
                    'id' => $notificacao->id,
                    'titulo' => $notificacao->titulo,
                    'mensagem' => $notificacao->mensagem
                ],
            ]);
        }catch(Exception $e){
            Log::info(['Erro ao ler notificação!' => $e]);

            return response()->json([
                'message' => $e,
                'success' => false
            ]);
        }
    }
}