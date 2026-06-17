<?php

namespace App\Services\Movidesk;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class MovideskService{
    public function salvaTicketMovidesk($payload){
        $token = env('MOVIDESK_API_KEY');
        $data = Carbon::now()->format('Y-m-d\TH:i:s.u');

        Log::info('Dados recebidos (MovideskClass): ', ['dados' => $payload]);

        //Consulta
        $response = Http::timeout(60)
    ->withHeaders([
        'Content-Type' => 'application/json',
    ])
    ->post(
        'https://api.movidesk.com/public/v1/tickets?token=' . $token,
        [
            'type' => 2,
            'subject' => $payload->titulo,
            'category' => 'Solicitação de Serviço', //Solicitação de serviço
            'urgency' => $payload->urgencia, //Baixa
            'status' => 'Resolvido', //Resolvido
            'justification' => '',
            'ownerTeam' => "SAF",
            'origin' => 2,
            'createdDate' => $data,
            "serviceFirstLevel" => "Paciente",
            "serviceSecondLevel" => "Transferência de Paciente",
            "serviceThirdLevel" => null,
            "actions" => [
                [
                    "type" => 2,
                    "origin" => 2,
                    "description" => $payload->assunto,
                    "createdBy" => [
                        "id" => "1159788127",
                    ],
                ]
            ],
            "clients" => [
                [
                    "id" => "1159788127",
                ]
            ],
            "createdBy" => [
                "id" => "1159788127",
            ],
            "owner" => [
                "id" => "1159788127",
            ]
        ]
    );
        if (!$response->successful()) {
            throw new \Exception(
                'Erro ao criar ticket no Movidesk: '
                . $response->body()
            );
        }

        return $response;
    }
}