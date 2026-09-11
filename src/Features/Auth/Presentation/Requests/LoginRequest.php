<?php

declare(strict_types=1);

namespace Src\Features\Auth\Presentation\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validation de la requête de connexion.
 * La validation métier (is_active, password check) est dans LoginAction.
 * Ici on valide uniquement le format des entrées.
 */
final class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            'remember' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'L\'adresse email n\'est pas valide.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins :min caractères.',
        ];
    }
}
