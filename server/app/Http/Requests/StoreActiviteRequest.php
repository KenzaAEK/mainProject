<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
class StoreActiviteRequest extends FormRequest
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
            'titre' => 'required|string|max:255',
            'description' => 'required|string|max:2048',
            'objectif' => 'required|string|max:1024',
            'ageMin' => 'required|integer|between:1,100',
            'ageMax' => 'required|integer|between:1,100|gte:ageMin',
            'imagePub' => 'required|string|max:255',
            'lienYtb' => 'required|integer',
            'programmePdf' => 'required|string|max:255',
            'idTypeActivite' => 'required|exists:type_activites,idTypeActivite'
        ];
    }
    public function messages()
    {
        return [
            'titre.required' => 'Le titre est obligatoire.',
            'description.required' => 'La description est obligatoire.',
            'objectif.required' => 'L\'objectif est obligatoire.',
            'ageMin.required' => 'L\'âge minimum est obligatoire.',
            'ageMax.required' => 'L\'âge maximum est obligatoire.',
            'imagePub.required' => 'L\'image publicitaire est obligatoire.',
            'lienYtb.required' => 'Le lien YouTube est obligatoire.',
            'programmePdf.required' => 'Le PDF du programme est obligatoire.',
            'idTypeActivite.required' => 'Le type d\'activité est obligatoire.',
            'idTypeActivite.exists' => 'Le type d\'activité spécifié n\'est pas valide.',
            'ageMax.gte' => 'L\'âge maximum doit être supérieur ou égal à l\'âge minimum.',
        ];
    }
}