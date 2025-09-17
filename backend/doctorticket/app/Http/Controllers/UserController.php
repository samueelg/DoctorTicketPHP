<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        return view('User.users_list', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createUser()
    {
        return view('User.create_user');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'ramal' => 'required',
            'senha' => 'required|min: 8',
            'tipo' => 'required'
        ],
        [
            'nome.required'  => 'É necessário preencher o campo nome',
            'ramal.required' => 'É necessário preencher o campo ramal',
            'senha.required' => 'É necessário preencher o campo senha',
            'senha.min'      => 'A senha deve ter no mínimo 8 caractéres',
            'tipo.required'  => 'É necessário escolher o tipo de usuário'
        ]);

        $user = new User();
        $user->nome = $request->nome;
        $user->ramal = $request->ramal;
        $user->senha = $request->senha;
        $user->tipo = $request->tipo;
        $user->save();
        
        return redirect()->route('usersList');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {   
        if($user->id == null){
            return redirect()->route('usersList');
        }

        return view('User.edit_user', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'nome' => 'required',
            'ramal' => 'required',
            'senha' => 'required|min: 8',
            'tipo' => 'required'
        ],
        [
            'nome.required'  => 'É necessário preencher o campo nome',
            'ramal.required' => 'É necessário preencher o campo ramal',
            'senha.required' => 'É necessário preencher o campo senha',
            'senha.min'      => 'A senha deve ter no mínimo 8 caractéres',
            'tipo.required'  => 'É necessário escolher o tipo de usuário'
        ]);

        $user->nome  = $request->nome;
        $user->ramal = $request->ramal;
        $user->senha = $request->senha;
        $user->tipo  = $request->tipo;
        $user->save();

        return redirect()->route('usersList');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
