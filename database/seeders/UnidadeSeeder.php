<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnidadeSeeder extends Seeder
{
    public function run(): void
    {
        $arquivo = storage_path('app/imports/ClinicasImport.CSV');

        $handle = fopen($arquivo, 'r');

        if (!$handle) {
            throw new \Exception('Não foi possível abrir o arquivo CSV.');
        }

        $cabecalho = fgetcsv($handle, 1000, ';');

        DB::transaction(function () use ($handle, $cabecalho) {
        while (($row = fgetcsv($handle, 1000, ';')) !== false) {
            if (count(array_filter($row)) === 0) {
                continue;
            }

            $dados = array_combine($cabecalho, $row);

            $dados = array_map(function ($valor) {
                return trim(
                    mb_convert_encoding($valor, 'UTF-8', 'Windows-1252')
                );
            }, $dados);

            DB::table('unidade')->updateOrInsert(
                [
                    'nomeUnidade' => trim($dados['clinica'])
                ],
                [
                    'cidade' => trim($dados['cidade']),
                    'estado' => trim($dados['estado']),
                    'updated_at' => now(),
                ]
            );
        }
        });

        fclose($handle);
    }
}