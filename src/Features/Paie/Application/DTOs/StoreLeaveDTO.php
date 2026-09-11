<?php

namespace Src\Features\Paie\Application\DTOs;

class StoreLeaveDTO
{
    public function __construct(
        public readonly int $tenantId,
        public readonly int $employeeId,
        public readonly string $type,
        public readonly string $dateDebut,
        public readonly string $dateFin,
        public readonly int $nbJours,
        public readonly ?string $motif,
        public readonly ?string $notes,
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            tenantId: $data['tenant_id'],
            employeeId: $data['employee_id'],
            type: $data['type'],
            dateDebut: $data['date_debut'],
            dateFin: $data['date_fin'],
            nbJours: (int) $data['nb_jours'],
            motif: $data['motif'] ?? null,
            notes: $data['notes'] ?? null,
        );
    }
}
