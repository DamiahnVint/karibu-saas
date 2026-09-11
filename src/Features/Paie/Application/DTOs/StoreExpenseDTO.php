<?php

namespace Src\Features\Paie\Application\DTOs;

class StoreExpenseDTO
{
    public function __construct(
        public readonly int $tenantId,
        public readonly int $employeeId,
        public readonly string $date,
        public readonly string $categorie,
        public readonly int $montant,
        public readonly ?string $description,
        public readonly ?string $justificatifPath,
        public readonly ?string $notes,
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            tenantId: $data['tenant_id'],
            employeeId: $data['employee_id'],
            date: $data['date'],
            categorie: $data['categorie'],
            montant: (int) $data['montant'],
            description: $data['description'] ?? null,
            justificatifPath: $data['justificatif_path'] ?? null,
            notes: $data['notes'] ?? null,
        );
    }
}
