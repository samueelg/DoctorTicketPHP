<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens;

    protected $table = 'Usuario';
    protected $fillable = [
        'nome',
        'ramal',
        'email',
        'senha',
        'tipo',
        'status'
    ];

    public function getAuthPassword()
    {
        return $this->senha;
    }

    public function notificacoes(){
        $this->hasMany(Notificacao::class, 'idUsuario');
    }

    protected $hidden = [
        'senha',
    ];
}
