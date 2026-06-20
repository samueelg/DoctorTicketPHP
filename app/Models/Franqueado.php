<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Franqueado extends Model
{
    protected $table = 'franqueado';

    protected $fillable = [
        'nome',
        'email',
        'idUnidade',
        'idMovidesk',
    ];

    public function tickets(){
        return $this->hasMany(Ticket::class, 'solicitante');
    }

    public function ligacao(){
        return $this->hasMany(Ligacao::class, 'idFranqueado');
    }
}
