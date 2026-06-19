<?php

namespace App\Services\Exportacao\Providers;

use App\Services\Exportacao\Providers\ExportacaoProvider;
use Exception;
use Illuminate\Support\Facades\Log;
use Shuchkin\SimpleXLSXGen;

class ExcelExportacaoProvider implements ExportacaoProvider {
    public function gerar(array $dados): array
    {
        try {
            $xlsx = new SimpleXLSXGen();

            $rows = $this->carregaDadosTabela($dados);
            $xlsx->addSheet($rows, 'Relatório');
            $xlsx->setCompany('Oral Sin Franquias<contato@oralsin.com.br>');
            $xlsx->setTitle('Chats WhatsApp');
            $xlsx->setLanguage('pt-BR');

            return [
                'conteudo' => $xlsx->__toString(),
                'extensao' => 'xlsx',
                'mime'     => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ];
        } catch (Exception $e) {
            Log::error(
                'Erro ao realizar a extração: ' . $e->getMessage(),
                ['trace' => $e->getTraceAsString()]
            );

            throw $e;
        }
    }

    protected function carregaDadosTabela(array $dados): array{
        $rows = [];

        //Cabeçalhos
        $rows[] = [
            '<b>idTicket</b>',
            '<b>Assunto</b>',
            '<b>Data Resolução</b>',
            '<b>Status</b>',
            '<b>Criado por</b>',
            '<b>Responsável</b>',
        ];

        //Dados
        foreach ($dados as $dado) {
            $row = $this->formataRow($dado);
            $rows[] = $row;
        }

        return $rows;
    }

    protected function formataRow(array $dado): array{
        return [
            $dado['id'],
            $dado['subject'],
            $dado['resolvedIn'] ?? 'Não Informado',
            $dado['status'],
            $dado['createdBy']['businessName'] ?? 'Não Informado',
            $dado['owner']['businessName'] ?? 'Não Informado',
        ];
    }
}
