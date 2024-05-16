<?php

namespace App\Http\Requests\Tuteur;

use Illuminate\Foundation\Http\FormRequest;

class StoreDemandeInscriptionRequest extends FormRequest
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
            'optionsPaiement' => 'required|string|max:50',
            'status' => 'required|in:en attente,acceptée,refusée',
            'idTuteur' => 'required', // the idTuteur should be in tuteurs table
            'idPack' => 'required', // the idPack should be in packs table
            'dateDemande' => 'required|date' 
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
