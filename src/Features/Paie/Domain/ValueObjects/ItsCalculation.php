<?php

namespace Src\Features\Paie\Domain\ValueObjects;

/**
 * Represente le calcul de l'ITS (Impot sur les Traitements et Salaires).
 * Contient le detail du calcul par tranche et le credit d'impot.
 */
class ItsCalculation
{
    public function __construct(
        public readonly int $baseImposable = 0,
        public readonly int $tranche1 = 0,
        public readonly int $tranche2 = 0,
        public readonly int $tranche3 = 0,
        public readonly int $tranche4 = 0,
        public readonly int $tranche5 = 0,
        public readonly int $itsBrut = 0,
        public readonly int $creditImpot = 0,
        public readonly int $itsNet = 0,
    ) {}

    public function toArray(): array
    {
        return [
            'its_base' => $this->baseImposable,
            'its_tranche1' => $this->tranche1,
            'its_tranche2' => $this->tranche2,
            'its_tranche3' => $this->tranche3,
            'its_tranche4' => $this->tranche4,
            'its_tranche5' => $this->tranche5,
            'its_brut' => $this->itsBrut,
            'its_credit' => $this->creditImpot,
            'its_net' => $this->itsNet,
        ];
    }
}
