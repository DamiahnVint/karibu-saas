<?php

declare(strict_types=1);

namespace Src\Features\Auth\Domain\Contracts;

use Src\Features\Common\Domain\ValueObjects\Email;

/**
 * Port de sortie pour l'accès aux données utilisateur.
 * L'Infrastructure (Eloquent) implémente ce contrat.
 * Le Domain ne connaît pas Eloquent ni la base de données.
 */
interface UserRepositoryInterface
{
    public function findByEmail(Email $email): ?array;

    public function findById(int $id): ?array;

    public function create(array $data): array;

    public function updateLastLogin(int $userId): void;

    public function emailExists(Email $email): bool;
}
