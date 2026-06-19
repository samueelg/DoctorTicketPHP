<?php

namespace App\Jobs;

use App\Services\Exportacao\Factories\ExportacaoFactory;
use App\Services\Relatorio\RelatorioService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GerarRelatorioJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    private array $filtros;
    private int $idUsuario;

    public function __construct(int $idUsuario, array $filtros)
    {
        $this->filtros   = $filtros;
        $this->idUsuario = $idUsuario;
    }

    /**
     * Execute the job.
     */
    public function handle(RelatorioService $relatorioService): void
    {
        $arquivo = $relatorioService->geraRelatorioExportacao(
            $this->filtros
        );

    // notificação websocket
    }
}
