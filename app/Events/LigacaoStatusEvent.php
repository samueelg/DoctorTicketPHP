<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;

class LigacaoStatusEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $ramal;
    public string $status;

    public function __construct(string $ramalEvent, string $statusEvent)
    {
        $this->ramal = $ramalEvent;
        $this->status = $statusEvent;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new PrivateChannel(
            'usuario.ramal.' . $this->ramal
        );
    }

    public function broadcastAs()
    {
        return 'ligacao.status';
    }

    public function broadcastWith()
    {
        //Ajustar retorno correto do payload
        return [
            'ramal' => $this->ramal,
            'status' => $this->status,
        ];
    }
}
