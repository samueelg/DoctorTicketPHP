<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){
        //Validate dos dados da request
        $request->validate([
            'email' => ['required', 'email'],
            'senha' => ['required', 'string']
        ], [
            'email.required' => 'É necessário preencher o campo email',
            'email.email' => 'O email deve ser válido',
            'senha.required' => 'É necessário preencher o campo senha',
            'senha.string' => 'A senha deve ser uma string'
        ]);

        $user = Usuario::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->senha, $user->senha)){
            return response()->json([
                'message' => 'Credenciais inválidas',
            ], 401);
        }

        //Cria token de autenticação
        $token = $user->createToken('tauri_auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login realizado com sucesso',
            'data' => [
                'id' => $user->id,
                'nome' => $user->nome,
                'email' => $user->email,
                'ramal' => $user->ramal,
                'tipo' => $user->tipo,
            ],
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logout realizado com sucesso',
        ], 200);
    }
}
