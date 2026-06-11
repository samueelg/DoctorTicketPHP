<?php

namespace App\Services\Exportacao;

use App\Services\Exportacao\Providers\ExportacaoProvider;

class ExportacaoService
{
    private ExportacaoProvider $provider;

    public function __construct(ExportacaoProvider $provider) {
        $this->provider = $provider;
    }

    public function exportar(array $dados) {
        return $this->provider->exportar($dados);
    }
}