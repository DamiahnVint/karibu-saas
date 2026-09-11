<?php

namespace Src\Features\Paie\Application\DTOs;

class GeneratePayslipDTO
{
    public function __construct(
        public readonly int $tenantId,
        public readonly int $employeeId,
        public readonly int $mois,
        public readonly int $annee,
        public readonly int $heuresSupJour = 0,
        public readonly int $heuresSupNuit = 0,
        public readonly int $primeAnciennete = 0,
        public readonly int $primeRendement = 0,
        public readonly int $primeRisque = 0,
        public readonly int $prime13eme = 0,
        public readonly int $indemniteTransport = 0,
        public readonly int $indemniteLogement = 0,
        public readonly int $indemniteResponsabilite = 0,
        public readonly int $avantagesNature = 0,
        public readonly ?string $notes = null,
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            tenantId: $data['tenant_id'],
            employeeId: $data['employee_id'],
            mois: (int) $data['mois'],
            annee: (int) $data['annee'],
            heuresSupJour: (int) ($data['heures_sup_jour'] ?? 0),
            heuresSupNuit: (int) ($data['heures_sup_nuit'] ?? 0),
            primeAnciennete: (int) ($data['prime_anciennete'] ?? 0),
            primeRendement: (int) ($data['prime_rendement'] ?? 0),
            primeRisque: (int) ($data['prime_risque'] ?? 0),
            prime13eme: (int) ($data['prime_13eme'] ?? 0),
            indemniteTransport: (int) ($data['indemnite_transport'] ?? 0),
            indemniteLogement: (int) ($data['indemnite_logement'] ?? 0),
            indemniteResponsabilite: (int) ($data['indemnite_responsabilite'] ?? 0),
            avantagesNature: (int) ($data['avantages_nature'] ?? 0),
            notes: $data['notes'] ?? null,
        );
    }
}
