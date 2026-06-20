<?php

namespace App\Services\Exportacao\Providers;

use App\Services\Exportacao\Providers\ExportacaoProvider;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfExportacaoProvider implements ExportacaoProvider {
    public function gerar(array $dados): array {
        try {
            $pdf = Pdf::loadView(
                'relatorio.relatorio',
                ['dados' => $dados]
            );
            $pdf->setOption('margin-bottom', '20mm');
            $pdf->setOption('orientation', 'Landscape');
            $pdf->setOption('footer-right', '[page] / [toPage]');
            $pdf->setOption('footer-font-size', 10);
            $pdf->setOption('disable-smart-shrinking', true);

            return [
                'conteudo' => $pdf->output(),
                'extensao' => 'pdf',
                'mime'     => 'application/pdf',
            ];
        } catch (\Exception $e) {
            Log::error(
                'Erro ao realizar a extração: ' . $e->getMessage(),
                ['trace' => $e->getTraceAsString()]
            );

            throw $e;
        }
    }
}
