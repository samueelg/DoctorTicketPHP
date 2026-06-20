<?php

namespace App\Services\Unidade;

use App\Models\Unidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UnidadeService{
    public function getUnidades(){
        $unidades = Unidade::all();

        return response()->json([
            'data' => $unidades,
        ], 200);
    }

    public function getUnidadePorNome(string $nome){
        $unidade = Unidade::query()
            ->select('id')
            ->where(function ($query) use ($nome) {
                $palavras = preg_split('/\s+/', trim($nome));

                foreach ($palavras as $palavra) {
                    $query->where('nomeUnidade', 'like', "%{$palavra}%");
                }       
            })->first();

        return $unidade?->id;
    }
}