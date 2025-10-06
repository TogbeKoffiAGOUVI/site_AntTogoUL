<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:2|max:128',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                'confirmed',
                'password' => Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => "Renseigne ton nom si tu ne veux pas m'énerver ! J'ai pas encore mangé hein ...",
            'name.min' => "Au moins 2 caractères pour le nom.",
            'name.max' => "Au plus 128 caractères pour le nom.",
            'email.required' => "E-mail requis.",
            'email.email' => "E-mail non valide.",
            'email.unique' => "E-mail déjà utilisé.",
            'password.required' => "Mot de passe requis.",
            'password.confirmed' => "Les deux mot de passe ne sont pas identiques.",
            'password.min' => "Au moins 8 caractères pour le mot de passe.",
            'password.mixed' => "Au moins 1 caractère majuscule et minuscule.",
            'password.symbols' => "Au moins 1 caractère spécial.",
            'password.numbers' => "Au moins 1 chiffre.",
        ];
    }
}
