<?php

namespace App\Services\Movidesk;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class MovideskService{
    public function salvaTicketMovidesk($payload){        
        $token = env('MOVIDESK_API_KEY');
        $data = Carbon::now()->format('Y-m-d\TH:i:s.u');
        $idMovideskUsuario = $payload->user()->idMovidesk;

        $ticket = [
            'type' => 2,
            'subject' => $payload->titulo,
            'category' => 'Solicitação de Serviço', //Solicitação de serviço
            'urgency' => $payload->urgencia, //Baixa
            'status' => 'Resolvido', //Resolvido
            'justification' => '',
            'ownerTeam' => "SAF", //Trocar pra SAF depois
            'origin' => 2,
            'createdDate' => $data,
            'serviceFirstLevelId' => $payload->serviceFirstLevelId,
            "actions" => [
                [
                    "type" => 2,
                    "origin" => 2,
                    "description" => nl2br(e($payload->assunto)),
                    "createdBy" => [
                        "id" => (string) trim("$idMovideskUsuario"),
                    ],
                ]
            ],
            "clients" => [
                [
                    "id" => (string) trim($payload->solicitante),
                ]
            ],
            "createdBy" => [
                "id" => (string) trim($payload->solicitante),
            ],
            "owner" => [
                "id" => (string) trim($idMovideskUsuario),
            ]
        ];

        $setor = $this->montaCampoSetor($payload->setor);

        if ($setor) {
            $ticket['customFieldValues'] = [$setor];
        }

        //Consulta
        $response = Http::timeout(60)
            ->withHeaders(['Content-Type' => 'application/json',])
            ->post(
                'https://api.movidesk.com/public/v1/tickets?token=' . $token,
                $ticket
            );

        if (!$response->successful()) {
            throw new \Exception(
                'Erro ao criar ticket no Movidesk: '
                . $response->body()
            );
        }

        return $response;
    }

    /**
     * Monta o campo adicional "Setor". Como é um campo do tipo lista, o valor vai
     * em items[].customFieldItem (e não em "value") e precisa ser idêntico ao item
     * cadastrado no Movidesk. Setor ausente ou fora do mapeamento não é enviado.
     */
    private function montaCampoSetor($setor): ?array
    {
        if (!in_array($setor, array_keys(config('movidesk.setores', [])), true)) {
            if (!empty($setor)) {
                Log::warning('Setor não enviado ao Movidesk por estar fora do mapeamento: ' . $setor);
            }

            return null;
        }

        $config = config('movidesk.setor');

        return [
            'customFieldId'     => $config['customFieldId'],
            'customFieldRuleId' => $config['customFieldRuleId'],
            'line'              => $config['line'] ?? 1,
            'items'             => [
                ['customFieldItem' => $setor],
            ],
        ];
    }
}