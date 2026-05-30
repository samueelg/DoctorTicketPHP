<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'ticket';
    protected $fillable = [
        'titulo',
        'assunto',
        'data_conclusao',
        'status',
        'idUsuario',
        'categoria',
        'solicitante',
        'urgencia',
    ];
}
