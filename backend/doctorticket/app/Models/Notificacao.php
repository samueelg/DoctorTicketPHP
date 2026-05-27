<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacao extends Model
{
    protected $table = 'Notificacao';
    protected $fillable = [
        'idUsuario',
        'titulo',
        'mensagem',
        'tipo',
        'lida_em'
    ];

    public function usuario(){
        $this->belongsTo(Usuario::class, 'idUsuario');
    }
}
