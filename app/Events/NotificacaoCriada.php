<?php

namespace App\Events;

use App\Models\Notificacao;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Queue\SerializesModels;

class NotificacaoCriada implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Notificacao $notificacao;
    
    public function __construct(Notificacao $notificacao)
    {
        $this->notificacao = $notificacao;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        //Ajustar depois pra private
        return new Channel(
            'usuario.' . $this->notificacao->idUsuario
        );
    }

    public function broadcastAs()
    {
        return 'notificacao.criada';
    }

    public function broadcastWith()
    {
        //Ajustar retorno correto do payload
        return [
            'id' => $this->notificacao->id,
            'titulo' => $this->notificacao->titulo,
            'mensagem' => $this->notificacao->mensagem,
        ];
    }
}
