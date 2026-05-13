<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Criar usuario
        Usuario::create([
            'id' => 1,
            'nome' => 'admin',
            'ramal' => 1,
            'senha' => Hash::make('admin'),
            'email' => 'admin@admin.com',
            'status' => 'ativo',
            'tipo' => 'admin'
        ]);
    }
}
