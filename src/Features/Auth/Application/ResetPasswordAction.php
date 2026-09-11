<?php

declare(strict_types=1);

namespace Src\Features\Auth\Application;

use Illuminate\Support\Facades\Password;

/**
 * Use Case : Réinitialisation de mot de passe.
 */
final class ResetPasswordAction
{
    /**
     * @return array{success: bool, message: string}
     */
    public function execute(array $data): array
    {
        $status = Password::reset(
            [
                'email' => $data['email'],
                'password' => $data['password'],
                'password_confirmation' => $data['password_confirmation'],
                'token' => $data['token'],
            ],
            function ($user, $password) {
                $user->forceFill([
                    'password' => \Illuminate\Support\Facades\Hash::make($password),
                    'remember_token' => \Illuminate\Support\Str::random(60),
                ])->save();
            }
        );

        return [
            'success' => $status === Password::PASSWORD_RESET,
            'message' => __($status),
        ];
    }
}
