<?php

namespace App\Services\Relatorio;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RelatorioService{
    public function getTicketsChat($filters){
        $token = env('MOVIDESK_API_KEY');

        //Consulta
        $response = Http::timeout(60)
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->get(
                "https://api.movidesk.com/public/v1/tickets",
                [
                    'token' => $token,
                    'id' => 147450,
                ]
            );
        if (!$response->successful()) {
            throw new \Exception(
                'Erro ao criar ticket no Movidesk: '
                . $response->body()
            );
        }

        return $response->json();
    }
}

