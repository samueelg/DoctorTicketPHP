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
}
