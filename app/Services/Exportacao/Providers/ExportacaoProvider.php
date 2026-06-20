<?php

namespace App\Services\Exportacao\Providers;

interface ExportacaoProvider {
    public function gerar(array $dados): array;
}