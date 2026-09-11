<?php

declare(strict_types=1);

namespace Src\Features\Auth\Infrastructure;

use App\Models\User;
use Src\Features\Auth\Domain\Contracts\UserRepositoryInterface;
use Src\Features\Common\Domain\ValueObjects\Email;

/**
 * Implémentation Eloquent du UserRepositoryInterface.
 *
 * C'est la seule couche qui touche Eloquent.
 * Le Domain ne connaît pas ce fichier.
 */
final class EloquentUserRepository implements UserRepositoryInterface
{
    public function __construct(
        private readonly User $model,
    ) {}

    public function findByEmail(Email $email): ?array
    {
        $user = $this->model->newQuery()
            ->where('email', $email->value())
            ->with('tenant:id,name')
            ->first();

        if (!$user) {
            return null;
        }

        return $this->toArray($user);
    }

    public function findById(int $id): ?array
    {
        $user = $this->model->newQuery()
            ->with('tenant:id,name')
            ->find($id);

        if (!$user) {
            return null;
        }

        return $this->toArray($user);
    }

    public function create(array $data): array
    {
        $user = $this->model->create($data);

        return $this->toArray($user->load('tenant:id,name'));
    }

    public function updateLastLogin(int $userId): void
    {
        $this->model->newQuery()
            ->where('id', $userId)
            ->update(['last_login_at' => now()]);
    }

    public function emailExists(Email $email): bool
    {
        return $this->model->newQuery()
            ->where('email', $email->value())
            ->exists();
    }

    private function toArray(User $user): array
    {
        $data = $user->makeVisible('password')->toArray();
        $data['tenant_name'] = $user->tenant?->name;
        return $data;
    }
}
