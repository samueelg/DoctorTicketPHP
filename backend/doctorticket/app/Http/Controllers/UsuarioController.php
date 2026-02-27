<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function getUsuarios(){
        $usuarios = Usuario::all();
        
        return response()->json([
            'data' => $usuarios,
        ], 200);
    }

    /* Salva o usuário no banco de dados */
    public function saveUsuario(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'ramal' => 'required|unique:usuarios,ramal',
            'senha' => 'required|min:8',
            'tipo' => 'required'
        ],
        [
            'nome.required'  => 'É necessário preencher o campo nome',
            'ramal.required' => 'É necessário preencher o campo ramal',
            'ramal.unique'   => 'Este ramal já esta sendo utilizado',
            'senha.required' => 'É necessário preencher o campo senha',
            'senha.min'      => 'A senha deve ter no mínimo 8 caractéres',
            'tipo.required'  => 'É necessário escolher o tipo de usuário'
        ]);

        $user = new Usuario();
        $user->nome = $request->nome;
        $user->ramal = $request->ramal;
        $user->senha = $request->senha;
        $user->tipo = $request->tipo;
        $user->save();
        
        return redirect()
            ->route('usersList')
            ->with('success', 'Usuário criado com sucesso!');
    }

    /* Exibe a view de editar usuário */
    public function getEditView(Usuario $user)
    {   
        if($user->id == null){
            return redirect()
            ->route('usersList')
            ->with('error', 'ID Usuário não encontrado');
        }

        return view('User.edit_user', ['user' => $user]);
    }

    /* Guarda os dados de edição do usuário no banco*/
    public function editUsuario(Request $request, Usuario $user)
    {
        $request->validate([
            'nome' => 'required',
            'ramal' => 'required',
            'senha' => 'required|min: 8',
            'tipo' => 'required',
        ],
        [
            'nome.required'  => 'É necessário preencher o campo nome',
            'senha.required' => 'É necessário preencher o campo senha',
            'senha.min'      => 'A senha deve ter no mínimo 8 caractéres',
            'tipo.required'  => 'É necessário escolher o tipo de usuário',
        ]);

        $user->nome   = $request->nome;
        $user->ramal  = $request->ramal;
        $user->senha  = $request->senha;
        $user->tipo   = $request->tipo;
        $user->status = $request->status;
        $user->save();

        return redirect()
            ->route('usersList')
            ->with('success', 'Usuário editado com sucesso!');
    }

    /* Remoção do usuário  */
    public function removeUsuario(Usuario $user)
    {
        if(!$user){
            return redirect()
                ->route('usersList')
                ->with('error', 'Usuário não encontrado.');
        }
        $user->delete();
        return redirect()
            ->route('usersList')
            ->with('success', 'Usuário deletado com sucesso');
    }
}
