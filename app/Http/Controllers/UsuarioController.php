<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Models\Usuario;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function getDadosUsuario(Request $request)
    {
        $usuario = $request->user();

        return response()->json([
            'id' => $usuario->id,
            'nome' => $usuario->nome,
            'ramal' => $usuario->ramal,
            'idMovidesk' => $usuario->idMovidesk,
        ]);
    }

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
    public function salvarUsuario(SaveUsuarioRequest $request)
    {
        try {
            $usuario = Usuario::create([
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
                    'id' => $usuario->id,
                    'nome' => $usuario->nome,
                    'email' => $usuario->email,
                    'ramal' => $usuario->ramal,
                    'tipo' => $usuario->tipo,
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
    public function editarUsuario(UpdateUsuarioRequest $request, Usuario $user)
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
    public function removerUsuario(Usuario $user)
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

    public function salvarConfiguracao(Request $request, Usuario $user){
        if (!$user) {
            return response()->json([
                'message' => 'Usuário não encontrado',
            ], 404);
        }

        $idMovidesk = $request->idMovidesk;

        if(!$idMovidesk){
            return response()->json([
                'message' => 'idMovidesk vazio!',
            ], 404);
        }

        try{
            $user->update([
                    'idMovidesk'  => $idMovidesk,
            ]);
        }catch (Exception $e) {
            report($e);
            return response()->json([
                'message' => 'Erro ao salvar configurações',
            ], 500);
        }

        return response()->json([
            'message' => 'idMovidesk adicionado com sucesso!',
        ], 200);
    }
}
