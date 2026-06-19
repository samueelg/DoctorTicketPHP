<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RelatorioGerado implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $idUsuario;
    public array $arquivo;

    public function __construct(int $idUsuario, array $arquivo)
    {
        $this->idUsuario = $idUsuario;
        $this->arquivo   = $arquivo;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('relatorios.usuario.' . $this->idUsuario);
    }

    public function broadcastAs(): string
    {
        return 'relatorio.gerado';
    }

    public function broadcastWith(): array
    {
        return [
            'nome' => $this->arquivo['nome'] ?? null,
            'mime' => $this->arquivo['mime'] ?? null,
            'erro' => $this->arquivo['erro'] ?? null,
        ];
    }
}
