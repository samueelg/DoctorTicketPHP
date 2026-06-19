<?php

namespace App\Services\Relatorio;

use App\Models\Usuario;
use DateTime;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RelatorioService{
    public function getTicketsChat($filtros){
        $token = env('MOVIDESK_API_KEY');

        $dataInicio = new DateTime($filtros['data'][0]);
        $dataFim = new DateTime($filtros['data'][1]);
        $idMovideskUsuario = '';

        // incluir o último dia inteiro
        $dataFim->modify('+1 day');

        // Formatar para padrão ISO com timezone -03:00
        $dataInicio = $dataInicio->format('Y-m-d\T00:00:00-03:00');
        $dataFim = $dataFim->format('Y-m-d\T00:00:00-03:00');

        $selectQuery = 'id,createdDate,subject,resolvedIn, owner, createdBy, status';
        $expand = 'owner, createdBy';
        $filter = "createdDate ge $dataInicio and createdDate lt $dataFim and origin eq Movidesk.Core.Data.Enums.TicketOrigin'23'";

        if($filtros['usuario']){
            $idMovideskUsuario = Usuario::select('idMovidesk')->find($filtros['usuario']);

            $filter .= " and owner/id eq '{$idMovideskUsuario->idMovidesk}'";
        }

        //Consulta
        $response = Http::timeout(60)
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->get(
                "https://api.movidesk.com/public/v1/tickets",
                [
                    'token' => $token,
                    '$select' => $selectQuery,
                    '$filter' => $filter,
                    '$expand' => $expand
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

