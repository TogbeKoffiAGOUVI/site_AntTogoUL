<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    
    /**
     * Determine if the user is authorized to make this request.
     */
        public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => [
                'required',
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
            'email.required' => "E-mail requis.",
            'email.email' => "E-mail non valide.",
            'password.required' => "Mot de passe requis.",
            'password.min' => "Au moins 8 caractères pour le mot de passe.",
            'password.mixed' => "Au moins 1 caractère majuscule et minuscule.",
            'password.symbols' => "Au moins 1 caractère spécial.",
            'password.numbers' => "Au moins 1 chiffre.",
        ];
    }
}