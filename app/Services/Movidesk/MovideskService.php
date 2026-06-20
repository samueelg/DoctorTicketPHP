<?php

namespace App\Services\Movidesk;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class MovideskService{
    public function salvaTicketMovidesk($payload){
        Log::info('debug payload salva: ', ['dados ' => $payload]);
        
        $token = env('MOVIDESK_API_KEY');
        $data = Carbon::now()->format('Y-m-d\TH:i:s.u');
        $idMovideskUsuario = $payload->user()->idMovidesk;

        //Consulta
        $response = Http::timeout(60)
            ->withHeaders(['Content-Type' => 'application/json',])
            ->post(
        'https://api.movidesk.com/public/v1/tickets?token=' . $token,
        [
            'type' => 2,
            'subject' => $payload->titulo,
            'category' => 'Solicitação de Serviço', //Solicitação de serviço
            'urgency' => $payload->urgencia, //Baixa
            'status' => 'Resolvido', //Resolvido
            'justification' => '',
            'ownerTeam' => "Desenvolvimento", //Trocar pra SAF depois
            'origin' => 2,
            'createdDate' => $data,
            "serviceFirstLevel" => $payload->serviceFirstLevel,
            "serviceSecondLevel" => $payload->serviceSecondLevel,
            "serviceThirdLevel" => null,
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