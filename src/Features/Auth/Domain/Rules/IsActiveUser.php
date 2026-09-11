<?php

declare(strict_types=1);

namespace Src\Features\Auth\Domain\Rules;

/**
 * Règle métier PHP pur : vérifie qu'un utilisateur est actif.
 * Testable sans Laravel, sans base de données, sans HTTP.
 */
final class IsActiveUser
{
    /**
     * Vérifie si l'utilisateur peut se connecter.
     *
     * @param array $userData Données brutes de l'utilisateur (tableau, pas Eloquent)
     * @return array{allowed: bool, reason: string}
     */
    public function check(array $userData): array
    {
        if (!isset($userData['is_active']) || !$userData['is_active']) {
            return [
                'allowed' => false,
                'reason' => 'Votre compte a été désactivé. Contactez l\'administrateur.',
            ];
        }

        if (isset($userData['deleted_at']) && $userData['deleted_at'] !== null) {
            return [
                'allowed' => false,
                'reason' => 'Ce compte a été supprimé.',
            ];
        }

        return ['allowed' => true, 'reason' => ''];
    }
}
