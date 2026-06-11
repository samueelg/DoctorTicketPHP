<?php

namespace App\Services\Exportacao\Providers;

use Symfony\Component\HttpFoundation\StreamedResponse;

interface ExportacaoProvider {
    public function exportar(array $dados): StreamedResponse;
}