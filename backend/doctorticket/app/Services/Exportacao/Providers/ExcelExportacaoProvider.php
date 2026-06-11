<?php

namespace App\Services\Exportacao\Providers;

use App\Services\Exportacao\Providers\ExportacaoProvider;
use Exception;
use Laravel\Reverb\Loggers\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Shuchkin\SimpleXLSXGen;

class ExcelExportacaoProvider implements ExportacaoProvider {
    public function exportar($dados): StreamedResponse
    {
        try {
            $xlsx = new SimpleXLSXGen();

            $rows = $this->carregaDadosTabela($dados);
            $xlsx->addSheet($rows, 'Relatório');
            $xlsx->setAuthor(session('nome'));
            $xlsx->setLastModifiedBy(session('nomeo'));
            $xlsx->setCompany('Oral Sin Franquias<contato@oralsin.com.br>');
            $xlsx->setTitle('Chats WhatsApp');
            $xlsx->setLanguage('pt-BR');

            $filename = "Manutencao_Midias_" . date("d-m-Y_H-i-s") . ".xlsx";
            return response()->streamDownload(
                function () use ($xlsx) {
                    echo $xlsx->__toString();
                },
                $filename,
                [
                    'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                ]
            );
        } catch (Exception $e) {
            Log::error(
                'Erro ao realizar a extração: ' . $e->getMessage(),
                ['trace' => $e->getTraceAsString()]
            );

            throw $e;
        }
    }

    protected function carregaDadosTabela($dados){
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

    protected function formataRow($dado){
        return [
            $dado['id'],
            $dado['subject'],
            $dado['resolvedIn'] ?? 'Não Informado',
            $dado['status'],
            'Teste',
            'teste2',
        ];
    }
}