<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Models\Usuario;
use Exception;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function getUsuarios(){
        $usuarios = Usuario::all();
        
        return response()->json([
            'data' => $usuarios,
        ], 200);
    }

    public function getUsuario(Usuario $user){
        if(!$user){
            return response()->json([
                'message' => 'Usuário não encontrado',
            ], 404);
        }

        return response()->json([
            'data' => $user,
        ], 200);
    }

    /* Salva o usuário no banco de dados */
    public function saveUsuario(SaveUsuarioRequest $request)
    {
        try {
            $user = Usuario::create([
                'nome'  => $request->nome,
                'ramal' => $request->ramal,
                'email' => $request->email,
                'senha' => Hash::make($request->senha),
                'tipo'  => $request->tipo,
                'status' => 'ativo',
            ]);

            return response()->json([
                'message' => 'Usuário criado com sucesso',
                'data' => [
                    'id' => $user->id,
                    'nome' => $user->nome,
                    'email' => $user->email,
                    'ramal' => $user->ramal,
                    'tipo' => $user->tipo,
                ],
            ], 201);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                'message' => 'Erro ao criar usuário',
            ], 500);
        }
    }

    /* Guarda os dados de edição do usuário no banco*/
    public function editUsuario(UpdateUsuarioRequest $request, Usuario $user)
    {
        if (!$user) {
            return response()->json([
                'message' => 'Usuário não encontrado',
            ], 404);
        }

        try {
            $user->update([
                'nome'  => $request->nome,
                'ramal' => $request->ramal,
                'email' => $request->email,
                'senha' => Hash::make($request->senha),
                'tipo'  => $request->tipo,
                'status' => 'ativo',
            ]);

            return response()->json([
                'message' => 'Usuário editado com sucesso',
                'data' => [
                    'id' => $user->id,
                    'nome' => $user->nome,
                    'email' => $user->email,
                    'ramal' => $user->ramal,
                    'tipo' => $user->tipo,
                ],
            ], 200);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                'message' => 'Erro ao editar usuário',
            ], 500);
        }
    }

    /* Remoção do usuário  */
    public function removeUsuario(Usuario $user)
    {
        if (!$user) {
            return response()->json([
                'message' => 'Usuário não encontrado',
            ], 404);
        }

        try {
            $user->delete();

            return response()->json([
                'message' => 'Usuário deletado com sucesso',
            ], 200);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                'message' => 'Erro ao deletar usuário',
            ], 500);
        }
    }
}
