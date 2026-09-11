<?php

declare(strict_types=1);

namespace Src\Features\Auth\Application;

use Illuminate\Support\Facades\Password;
use Src\Features\Common\Domain\ValueObjects\Email;

/**
 * Use Case : Demande de réinitialisation de mot de passe.
 *
 * Envoie un email avec un token de réinitialisation.
 * Pour l'instant, on stocke le token en DB (pas d'envoi email réel).
 */
final class ForgotPasswordAction
{
    /**
     * @return array{success: bool, message: string}
     */
    public function execute(Email $email): array
    {
        $status = Password::sendResetLink(
            ['email' => $email->value()]
        );

        return [
            'success' => $status === Password::RESET_LINK_SENT,
            'message' => __($status),
        ];
    }
}
