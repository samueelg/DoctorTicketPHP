<?php

namespace App\Http\Controllers;

use App\Services\Unidade\UnidadeService;
use Illuminate\Http\Request;

class UnidadeController extends Controller{
    private UnidadeService $oUnidadeService;

    public function __construct(UnidadeService $unidadeService)
    {
        $this->oUnidadeService = $unidadeService;
    }

    public function getUnidades(){
        return $this->oUnidadeService->getUnidades();
    }
}
