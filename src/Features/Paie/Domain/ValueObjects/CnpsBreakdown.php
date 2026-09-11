<?php

namespace Src\Features\Paie\Domain\ValueObjects;

/**
 * Represente les calculs CNPS (Caisse Nationale de Prevoyance Sociale).
 * Contient les taux et montants pour chaque branche de cotisation.
 */
class CnpsBreakdown
{
    public function __construct(
        public readonly int $retraiteSalarie = 0,
        public readonly int $cmuSalarie = 0,
        public readonly int $totalSalarie = 0,
        public readonly int $retraiteEmployeur = 0,
        public readonly int $maternite = 0,
        public readonly int $prestationsFamiliales = 0,
        public readonly int $accidentsTravail = 0,
        public readonly int $cmuEmployeur = 0,
        public readonly int $totalEmployeur = 0,
        public readonly int $totalGeneral = 0,
    ) {}

    public function toArray(): array
    {
        return [
            'retraite_salarie' => $this->retraiteSalarie,
            'cmu_salarie' => $this->cmuSalarie,
            'total_cnps_salarie' => $this->totalSalarie,
            'retraite_employeur' => $this->retraiteEmployeur,
            'maternite' => $this->maternite,
            'prestations_familiales' => $this->prestationsFamiliales,
            'accidents_travail' => $this->accidentsTravail,
            'cmu_employeur' => $this->cmuEmployeur,
            'total_cnps_employeur' => $this->totalEmployeur,
            'total_general' => $this->totalGeneral,
        ];
    }
}
