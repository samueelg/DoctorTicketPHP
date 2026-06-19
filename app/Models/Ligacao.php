<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ligacao extends Model
{
    protected $table = 'ligacao';
    protected $fillable = [
        'idUsuario',
        'idFranqueado',
    ];

    public function usuario(){
        return $this->belongsTo(Usuario::class, 'idUsuario');
    }

    public function franqueado(){
        return $this->belongsTo(Franqueado::class, 'idFranqueado');
    }
}
