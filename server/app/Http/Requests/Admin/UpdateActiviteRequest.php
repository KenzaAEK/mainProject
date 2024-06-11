<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActiviteRequest extends FormRequest
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
<<<<<<< HEAD
            'titre' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|max:2048',
            'objectif' => 'sometimes|string|max:1024',
            'ageMin' => 'sometimes|integer|between:1,100',
            'ageMax' => 'sometimes|integer|between:1,100|gte:ageMin',
            'imagePub' => 'sometimes|string|max:255',
            'lienYtb' => 'sometimes|numeric',
            'programmePdf' => 'sometimes|string|max:255',
            'type' => 'sometimes|exists:typeactivites,type'
=======
            'titre' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string|max:2048',
            'objectif' => 'sometimes|required|string|max:1024',
            'imagePub' => 'sometimes|file|mimes:jpg,jpeg,png|max:5000',
            'lienYtb' => 'sometimes|required|string|max:255',
            'programmePdf' => 'sometimes|file|mimes:pdf|max:10000',
            'type' => 'sometimes|required|exists:typeactivites,type'
>>>>>>> 1873be89298e6ff805fd205af55d2f40017f4b2f
        ];
    }
    public function messages()
    {
        return [
            'titre.required' => 'Le titre est obligatoire.',
            'description.required' => 'La description est obligatoire.',
            'objectif.required' => 'L\'objectif est obligatoire.',
            'lienYtb.required' => 'Le lien YouTube est obligatoire.',
            'type.required' => 'Le type d\'activité est obligatoire.',
            'type.exists' => 'Le type d\'activité spécifié n\'est pas valide.',
            'programmePdf.file' => 'Le document doit être un fichier.',
            'programmePdf.mimes' => 'Le document doit être un fichier PDF.',
            'programmePdf.max' => 'Le document ne doit pas dépasser 10MB.',
            'imagePub.file' => 'L\'image doit être un fichier.',
            'imagePub.mimes' => 'L\'image doit être de type JPEG, JPG ou PNG.',
            'imagePub.max' => 'L\'image ne doit pas dépasser 5MB.'
        ];
    }
}
