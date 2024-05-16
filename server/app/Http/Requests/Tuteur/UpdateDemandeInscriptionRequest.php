<?php

namespace App\Http\Requests\Tuteur;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDemandeInscriptionRequest extends FormRequest
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
            'optionsPaiement' => 'sometimes|string|max:50',
            'status' => 'sometimes|in:en attente,acceptée,refusée',
            'idTuteur' => 'sometimes', 
            'idPack' => 'sometimes', 
            'dateDemande' => 'sometimes|date' 
        
        ];
    }
    public function messages()
    {
        return [
            'idTuteur.exists' => 'Le tuteur spécifié n\'existe pas.',
            'idPack.exists' => 'Le pack spécifié n\'existe pas.'
        ];
    }
}
