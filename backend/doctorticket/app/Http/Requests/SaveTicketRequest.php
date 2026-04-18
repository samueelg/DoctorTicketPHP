<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveTicketRequest extends FormRequest
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
            'titulo' => ['required', 'string', 'max:255'],
            'assunto'=> ['required', 'string', 'max:5000'],
            'solicitante'=>['required', 'string','max:128'],
            'categoria'=>['required', 'string','max:128'],
            'urgencia'=>['required', 'string', 'max:128'],
            'status' => ['required', 'string','max:128'],        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required'       => 'É necessário preencher o campo título',
            'assunto.required'      => 'É necessário preencher o campo assunto',
            'solicitante.required'  => 'É necessário preencher o campo solicitante',
            'categoria.required'    => 'É necessário preencher o campo categoria',
            'urgencia.required'     => 'É necessário preencher o campo urgência',
            'status.required'       => 'É necessário preencher o campo status',
        ];
    }
}
