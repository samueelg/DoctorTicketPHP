<?php

namespace App\Services\Exportacao\Factories;

use App\Services\Exportacao\Providers\ExcelExportacaoProvider;
use App\Services\Exportacao\Providers\ExportacaoProvider;
use App\Services\Exportacao\Providers\PdfExportacaoProvider;

class ExportacaoFactory
{   
    public static function criar(string $tipo): ExportacaoProvider
    {
        return match ($tipo) {
            'excel' => new ExcelExportacaoProvider(),
            'pdf' => new PdfExportacaoProvider(),
            default => throw new \InvalidArgumentException(
                "Tipo de exportação inválido"
            ),
        };
    }
}