<?php

namespace App\Services\Exportacao\Providers;

use App\Services\Exportacao\Providers\ExportacaoProvider;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfExportacaoProvider implements ExportacaoProvider {
    public function exportar(array $dados): StreamedResponse {
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
    
            $filename = "Contas_Receber_" . date("d-m-Y_H-i-s") . ".pdf";
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->output();
            }, $filename,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]);
        } catch (\Exception $e) {
            Log::error(
                'Erro ao realizar a extração: ' . $e->getMessage(),
                ['trace' => $e->getTraceAsString()]
            );

            throw $e;
        }
    }
}