<?php

namespace Src\Features\Paie\Application\DTOs;

class StoreTimesheetDTO
{
    public function __construct(
        public readonly int $tenantId,
        public readonly int $employeeId,
        public readonly string $date,
        public readonly string $heureDebut,
        public readonly string $heureFin,
        public readonly int $pause,
        public readonly ?string $notes,
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            tenantId: $data['tenant_id'],
            employeeId: $data['employee_id'],
            date: $data['date'],
            heureDebut: $data['heure_debut'],
            heureFin: $data['heure_fin'],
            pause: (int) ($data['pause'] ?? 0),
            notes: $data['notes'] ?? null,
        );
    }
}
