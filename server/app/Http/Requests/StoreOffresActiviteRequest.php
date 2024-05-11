<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOffresActiviteRequest extends FormRequest
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
           
            'idActivite' => 'required|exists:activites,idActivite',
            'tarif' => 'required|numeric',
            'effmax' => 'required|integer',
            'effmin' => 'required|integer',
            'age_min' => 'required|integer',
            'age_max' => 'required|integer',
            'nbrSeance' => 'required|integer',
            'Duree_en_heure' => 'required|numeric',  // Assurez-vous que cette règle accepte les décimales si nécessaire
        ];
    }

}
