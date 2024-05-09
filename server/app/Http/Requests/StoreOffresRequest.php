<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
class StoreOffresRequest extends FormRequest
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
            'titre' => 'required|string|max:255',//
            'remise' => 'nullable|numeric',//
            'dateDebutOffre' => 'nullable|date|before_or_equal:dateFinOffre',//
            'dateFinOffre' => 'nullable|date|after_or_equal:dateDebutOffre',//
            'description' => 'nullable|string',//horaire+les ateliers+plage ages
        ];
    }
    public function messages()
    {
        return [
            'titre.required' => 'Le titre est obligatoire.',
            'titre.max' => 'Le titre ne peut pas dépasser :max caractères.',
            'remise.numeric' => 'La remise doit être un nombre.',
            'dateDebutOffre.date' => 'La date de début de l\'offre doit être une date valide.',
            'dateFinOffre.date' => 'La date de fin de l\'offre doit être une date valide.',
            'dateDebutOffre.before_or_equal' => 'La date de début de l\'offre doit être antérieure ou égale à la date de fin de l\'offre.',
            'dateFinOffre.after_or_equal' => 'La date de fin de l\'offre doit être postérieure ou égale à la date de début de l\'offre.',
            'description.string' => 'La description doit être une chaîne de caractères.',
        ];
    }
}