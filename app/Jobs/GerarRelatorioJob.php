<?php

namespace App\Jobs;

use App\Events\RelatorioGerado;
use App\Services\Notificacao\NotificacaoService;
use App\Services\Relatorio\RelatorioService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Throwable;

class GerarRelatorioJob implements ShouldQueue
{
    use Queueable;

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
    public function handle(
        RelatorioService $relatorioService,
        NotificacaoService $notificacaoService
    ): void {
        $arquivo = $relatorioService->geraRelatorioExportacao(
            $this->filtros
        );

        // Dispara o download no front
        event(new RelatorioGerado($this->idUsuario, $arquivo));

        $notificacaoService->criarNotificacao(
            $this->idUsuario,
            'Relatório pronto',
            'Seu relatório foi gerado com sucesso e já está disponível para download.',
            'relatorio'
        );
    }

    public function failed(Throwable $e): void
    {
        Log::error('Falha ao gerar relatório', [
            'idUsuario' => $this->idUsuario,
            'erro'      => $e->getMessage(),
        ]);

        event(new RelatorioGerado($this->idUsuario, [
            'erro' => 'Não foi possível gerar o relatório.',
        ]));

        app(NotificacaoService::class)->criarNotificacao(
            $this->idUsuario,
            'Falha ao gerar relatório',
            'Não foi possível gerar o relatório. Tente novamente.',
            'relatorio_erro'
        );
    }
}
