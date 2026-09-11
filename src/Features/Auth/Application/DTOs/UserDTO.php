<?php

declare(strict_types=1);

namespace Src\Features\Auth\Application\DTOs;

/**
 * DTO de sortie — expose les données utilisateur au frontend.
 * Jamais de modèle Eloquent en dehors de l'Infrastructure.
 */
final readonly class UserDTO
{
    private function __construct(
        public int $id,
        public string $name,
        public string $email,
        public ?string $role,
        public ?string $phone,
        public ?string $avatar,
        public bool $isActive,
        public ?int $tenantId,
        public ?string $tenantName,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            name: $data['name'] ?? '',
            email: $data['email'] ?? '',
            role: $data['role'] ?? null,
            phone: $data['phone'] ?? null,
            avatar: $data['avatar'] ?? null,
            isActive: (bool) ($data['is_active'] ?? true),
            tenantId: $data['tenant_id'] ?? null,
            tenantName: $data['tenant_name'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'phone' => $this->phone,
            'avatar' => $this->avatar,
            'is_active' => $this->isActive,
            'tenant_id' => $this->tenantId,
            'tenant_name' => $this->tenantName,
        ];
    }
}
