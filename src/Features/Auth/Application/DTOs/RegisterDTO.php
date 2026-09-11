<?php

declare(strict_types=1);

namespace Src\Features\Auth\Application\DTOs;

use Src\Features\Common\Domain\ValueObjects\Email;

/**
 * DTO immutable pour les données d'inscription.
 */
final readonly class RegisterDTO
{
    private function __construct(
        public string $name,
        public Email $email,
        public string $password,
        public ?string $phone,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: trim($data['name'] ?? ''),
            email: Email::fromString($data['email'] ?? ''),
            password: $data['password'] ?? '',
            phone: $data['phone'] ?? null,
        );
    }
}
