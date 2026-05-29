<?php

namespace App\Services\Notificacao;

use App\Events\NotificacaoCriada;
use Illuminate\Support\Facades\Event;
use App\Models\Notificacao;

class NotificacaoService{
    public function criarNotificacao(){

    $notificacao = Notificacao::create([
        'idUsuario' => 1,
        'titulo' => 'Teste',
        'mensagem' => 'Websocket funcionando'
    ]);
    
    Event::dispatch(new NotificacaoCriada($notificacao));
    }
}