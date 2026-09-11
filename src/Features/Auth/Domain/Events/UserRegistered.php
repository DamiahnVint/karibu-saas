<?php

declare(strict_types=1);

namespace Src\Features\Auth\Domain\Events;

/**
 * Événement métier émis lorsqu'un nouvel utilisateur s'inscrit.
 */
final readonly class UserRegistered
{
    public function __construct(
        public int $userId,
        public string $email,
        public string $name,
    ) {}
}
