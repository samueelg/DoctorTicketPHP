<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FranqueadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arquivo = storage_path('app/imports/FranqueadosImport.CSV');

        $handle = fopen($arquivo, 'r');

        if (!$handle) {
            throw new \Exception('Não foi possível abrir o arquivo CSV.');
        }

        $cabecalho = fgetcsv($handle, 1000, ';');

        $unidades = DB::table('unidade')
            ->pluck('id', 'nomeUnidade')
            ->toArray();
        
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

            $organizacao = trim($dados['organizacoes'] ?? '');

            if (empty($organizacao)) {
                $unidade = null;
            } else {

                // 1. Busca exata
                $unidade = $unidades[$organizacao] ?? null;

                // 2. Se não encontrou, busca parcial
                if ($unidade === null) {

                    $maiorMatch = 0;

                    foreach ($unidades as $nomeUnidade => $id) {

                        if (stripos($organizacao, $nomeUnidade) !== false) {

                            if (strlen($nomeUnidade) > $maiorMatch) {
                                $maiorMatch = strlen($nomeUnidade);
                                $unidade = $id;
                            }
                        }
                    }
                }

                // 3. Log para casos não encontrados
                if ($unidade === null) {
                    logger()->warning("Unidade não encontrada para organização: {$organizacao}");
                }
            }


            DB::table('franqueado')->updateOrInsert(
                [
                    'idMovidesk' => trim($dados['cod-ref']),
                    ],
                    [
                        'email' => trim($dados['email']),
                        'idUnidade' => $unidade,
                        'nome' => trim($dados['nomeFantasia'])
                ]
            );
        }
    }
}
