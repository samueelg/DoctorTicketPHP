<?php

namespace App\Services\Notificacao;

use App\Events\NotificacaoCriada;
use Illuminate\Support\Facades\Event;
use App\Models\Notificacao;
use Exception;

class NotificacaoService{
    public function criarNotificacao(){

    $notificacao = Notificacao::create([
        'idUsuario' => 1,
        'titulo' => 'Teste',
        'mensagem' => 'Websocket funcionando'
    ]);
    
    Event::dispatch(new NotificacaoCriada($notificacao));
    }

    public function getNotificacoes($request){
        try{
        $notificacao = Notificacao::whereNull('lida_em')
            ->where('idUsuario', $request->user()->id)
            ->get();

        return $notificacao;
        }catch(Exception $e){
            
        }
    }
}