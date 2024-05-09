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
            'tarif' => 'required|numeric',
            'effmax' => 'required|integer',
            'effmin' => 'required|integer',
            'nbrSeance' => 'required|integer',
            'Duree_en_heure' => 'required|integer',
            'idActivite' => 'required|exists:activites,idActivite',
            'age_max' => 'required|integer',
            'age_min' => 'required|integer',
        ];
    }


}
