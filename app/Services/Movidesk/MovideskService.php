<?php

namespace App\Services\Movidesk;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class MovideskService{
    public function salvaTicketMovidesk($payload){
        $token = env('MOVIDESK_API_KEY');
        $data = Carbon::now()->format('Y-m-d\TH:i:s.u');
        
        Log::info('Data', ['data' => $data]);
        Log::info('token', ['token' => $token]);

        Log::info('Dados recebidos: ', ['dados' => $payload]);

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
            'ownerTeam' => 'SAF',
            'origin' => 2,
            'createdDate' => $data,
            "serviceThirdLevel" => null,
            "serviceSecondLevel" => "Paciente",
            "serviceFirstLevel" =>"Transferência de Paciente",
            "actions" => [
                [
                    "id" => 1,
                    "type" => 2,
                    "origin" => 2,
                    "description" => $payload->assunto,
                    "status" => "Resolvido",
                    "justification" => null,
                    "createdDate" => $data,
                    "isDeleted" => false,
                    "tags" => []
                ]
            ],
            "clients" => [
                [
                "id" => "1159788127",
                "personType" => 1,
                "profileType" => 3,
                "email" => "samuel.goncalves@oralsinfranquias.com.br",
                ]
            ],
            "createdBy" => [
                [
                "id" => "1159788127",
                "personType" => 1,
                "profileType" => 3,
                "businessName" => "Samuel Gonçalves",
                "email" => "samuel.goncalves@oralsinfranquias.com.br",
                ]
            ],
            "owner" => [
                [
                "id" => "1159788127",
                "personType" => 1,
                "profileType" => 3,
                "businessName" => "Samuel Gonçalves",
                "email" => "samuel.goncalves@oralsinfranquias.com.br",
                ]
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