<?php

namespace App\Services\Exportacao\Providers;

use App\Services\Exportacao\Providers\ExportacaoProvider;
use Illuminate\Http\Response;

class PdfExportacaoProvider implements ExportacaoProvider {
    public function exportar(array $dados): Response {

    }
}