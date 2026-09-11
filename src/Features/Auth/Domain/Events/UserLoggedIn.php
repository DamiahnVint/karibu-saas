<?php

declare(strict_types=1);

namespace Src\Features\Auth\Domain\Events;

/**
 * Événement métier émis lorsqu'un utilisateur se connecte avec succès.
 * Utilisable pour audit trail, notifications, analytics.
 */
final readonly class UserLoggedIn
{
    public function __construct(
        public int $userId,
        public string $email,
        public string $ipAddress,
        public string $userAgent,
    ) {}
}
