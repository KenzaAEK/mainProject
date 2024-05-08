<?php

namespace App\Http\Requests;

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
            'titre' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|max:2048',
            'objectif' => 'sometimes|string|max:1024',
            'ageMin' => 'sometimes|integer|between:1,100',
            'ageMax' => 'sometimes|integer|between:1,100|gte:ageMin',
            'imagePub' => 'sometimes|string|max:255',
            'lienYtb' => 'sometimes|numeric',
            'programmePdf' => 'sometimes|string|max:255',
            'idTypeActivite' => 'sometimes|exists:type_activites,idTypeActivite'
        ];
    }
    public function messages()
    {
        return [
            'ageMax.gte' => 'L\'age maximum doit être supérieur ou égal à l\'age minimum'

        ];
    }
}
