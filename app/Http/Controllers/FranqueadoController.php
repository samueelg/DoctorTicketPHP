<?php

namespace App\Http\Controllers;

use App\Models\Franqueado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FranqueadoController extends Controller
{
    public function getFranqueado(Request $request){
        $termo = $request->termo;
        
        $franqueados = Franqueado::query()
            ->leftJoin('unidade', 'franqueado.idUnidade', '=', 'unidade.id')
            ->where(function ($query) use ($termo) {
                $query->where('franqueado.nome', 'like', "%{$termo}%")
                    ->orWhere('franqueado.email', 'like', "%{$termo}%")
                ->orWhere('unidade.nomeUnidade', 'like', "%{$termo}%");
            })
            ->limit(50)
            ->get();

        return response()->json($franqueados);
    }
}
