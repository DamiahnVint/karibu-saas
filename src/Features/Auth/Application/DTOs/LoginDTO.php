<?php

declare(strict_types=1);

namespace Src\Features\Auth\Application\DTOs;

use Src\Features\Common\Domain\ValueObjects\Email;

/**
 * DTO immutable pour les données de connexion.
 * Valide et transporte les données de la couche Presentation vers Application.
 */
final readonly class LoginDTO
{
    private function __construct(
        public Email $email,
        public string $password,
        public bool $remember = false,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            email: Email::fromString($data['email'] ?? ''),
            password: $data['password'] ?? '',
            remember: $data['remember'] ?? false,
        );
    }
}
