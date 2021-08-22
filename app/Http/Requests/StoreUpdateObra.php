<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateObra extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tituloObra' => 'required',
            'tituloAlternativo' => 'nullable',
            'tipoObra' => 'required',
            'lancamentoObra' => 'required',
            'status' => 'required',
            'idAutor' => 'required',
            'idArtista' => 'required',
            'idGenero' => 'required'
        ];
    }

    public function messages(){
        return [
            'idGenero.required' => 'Escolha pelo menos um gênero!',
            'idAutor.required' => 'Escolha pelo menos um autor!',
            'idArtista.required' => 'Escolha pelo menos um artista!'
        ];
    }
}
