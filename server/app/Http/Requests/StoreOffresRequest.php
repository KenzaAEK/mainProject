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
            
        'titre' => 'required|string|max:255',
        'remise' => 'nullable|numeric',
        'dateDebutOffre' => 'required|date',
        'dateFinOffre' => 'required|date|after_or_equal:dateDebutOffre',
        'description' => 'nullable|string',
        'activites' => 'required|array|min:1', 
        'activites.*.titre' => 'required|string|max:255', 
        'activites.*.tarif' => 'required|numeric',
        'activites.*.effmax' => 'required|integer',
        'activites.*.effmin' => 'required|integer',
        'activites.*.age_min' => 'required|integer',
        'activites.*.age_max' => 'required|integer',
        'activites.*.jours' => 'required|array|min:1', // Nouveau tableau de jours
        'activites.*.jours.*.JourAtelier' => 'required|string', // Jour de la semaine
        'activites.*.jours.*.heureDebut' => 'required|date_format:H:i', // Heure de début au format H:i
        'activites.*.jours.*.heureFin' => 'required|date_format:H:i|after:activites.*.jours.*.heureDebut',
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
            'activites.*.idActivite.required' => 'L\'identifiant de l\'activité est obligatoire.',
            'activites.*.idActivite.exists' => 'L\'activité spécifiée n\'existe pas.',
        ];
    }
}
