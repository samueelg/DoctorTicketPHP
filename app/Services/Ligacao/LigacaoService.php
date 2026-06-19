<?php

namespace App\Services\Ligacao;

use App\Models\Ligacao;
use Exception;

class LigacaoService{
    public function salvaLigacao(array $dados){
        try{
            return Ligacao::create([
                'idUsuario' => $dados['idUsuario'],
                'idFranqueado' => $dados['idFranqueado']
            ]);
        }catch (Exception $e) {
            report($e);
            return response()->json([
                'message' => 'Erro ao criar usuário',
            ], 500);
        }
    }
}