<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nome' => 'Samuel Melo',
            'ramal' => '232',
            'senha' => 'teste123',
            'status' => 'ativo',
            'tipo' => 'analista'
        ]);

        User::create([
            'nome' => 'Joao',
            'ramal' => '235',
            'senha' => 'teste123',
            'status' => 'ativo',
            'tipo' => 'analista'
        ]);
    }
}
