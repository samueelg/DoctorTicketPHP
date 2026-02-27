<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveUsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => ['required'],
            'ramal' => ['required', 'unique:usuarios,ramal'],
            'email' => ['email', 'unique:usuarios,email'],
            'senha' => ['required', 'min:8'],
            'tipo' => ['required']
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required'  => 'É necessário preencher o campo nome',
            'ramal.required' => 'É necessário preencher o campo ramal',
            'ramal.unique'   => 'Este ramal já esta sendo utilizado',
            'email.unique'   => 'Este email já esta sendo utilizado',
            'senha.required' => 'É necessário preencher o campo senha',
            'senha.min'      => 'A senha deve ter no mínimo 8 caractéres',
            'tipo.required'  => 'É necessário escolher o tipo de usuário'
        ];
    }
}
