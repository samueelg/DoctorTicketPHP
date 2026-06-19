<?php

namespace App\Services\Franqueado;

use App\Models\Franqueado;
use Illuminate\Support\Facades\Log;

class FranqueadoService{
    public function getFranqueadoPorUnidade(string $unidade){
        $palavras = preg_split('/\s+/', trim($unidade));

        //Busca por e-mails que começam com o nome da unidade
        $email = Franqueado::query()
            ->select('f.email', 'f.idMovidesk')
            ->from('franqueado as f')
            ->leftJoin('unidade as u', 'f.idUnidade', '=', 'u.id')
            ->where(function ($query) use ($palavras) {
                foreach ($palavras as $index => $palavra) {
                    if ($index === 0) {
                        $query->where('f.email', 'like', "{$palavra}%");
                    } else {
                        $query->where('f.email', 'like', "%{$palavra}%");
                    }
                }
            })
            ->first();

        //Se não encontrar, busca e-mails que contenham atendimento/recepcao/comercial + nome da unidade
        if (!$email) {
            $email = Franqueado::query()
                ->select('f.email', 'f.idMovidesk')
                ->from('franqueado as f')
                ->leftJoin('unidade as u', 'f.idUnidade', '=', 'u.id')
                ->where(function ($query) {
                    $query->where('f.email', 'like', 'atendimento%')
                        ->orWhere('f.email', 'like', 'recepcao%')
                        ->orWhere('f.email', 'like', 'comercial%');
                })
                ->where(function ($query) use ($palavras) {
                    foreach ($palavras as $palavra) {
                        $query->where('f.email', 'like', "%{$palavra}%");
                    }
                })
                ->first();
        }

        //Se não encontro ainda, pega o e-mail de qualquer franqueado que tenha a unidade vinculada
        if (!$email) {
            $email = Franqueado::query()
                ->select('f.email', 'f.idMovidesk')
                ->from('franqueado as f')
                ->leftJoin('unidade as u', 'f.idUnidade', '=', 'u.id')
                ->where(function ($query) use ($palavras) {
                    foreach ($palavras as $palavra) {
                        $query->where('u.nomeUnidade', 'like', "%{$palavra}%");
                    }
                })
                ->first();
        }

        return $email;
    }
}