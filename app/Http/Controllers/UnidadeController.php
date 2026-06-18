<?php

namespace App\Http\Controllers;

use App\Models\Unidade;
use Illuminate\Http\Request;

class UnidadeController extends Controller
{
    public function getUnidades(){
        $unidades = Unidade::all();

        return response()->json([
            'data' => $unidades,
        ], 200);
    }
}
