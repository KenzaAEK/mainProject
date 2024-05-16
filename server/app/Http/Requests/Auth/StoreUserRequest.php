<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;


class StoreUserRequest extends FormRequest
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
            'nom' => ['required','string','max:255'],
            'prenom' => ['required', 'string','max:255'],
            'tel' => ['required','string','max:255','regex:/^[0-9]{10}$/'],
            'email' => ['required', 'string', 'email', 'max:255', ],
            'password' => ['required','confirmed',Rules\Password::defaults()],
        ];
    }
}
