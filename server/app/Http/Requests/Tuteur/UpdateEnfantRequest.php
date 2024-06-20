<?php

namespace App\Http\Requests\Tuteur;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEnfantRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'prenom' => 'sometimes|string|max:100',
            'nom' => 'sometimes|string|max:100',
            'dateNaissance' => 'sometimes|date|before:today',
            'niveauEtude' => 'sometimes|string|max:100',
            'idTuteur' => 'sometimes'
        ];
    }
    public function messages()
    {
        return [
            'idTuteur.exists' => 'Le tuteur spécifié n\'existe pas.'
        ];
    }
}
