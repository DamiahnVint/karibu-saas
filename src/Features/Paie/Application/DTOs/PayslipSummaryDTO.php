<?php

namespace Src\Features\Paie\Application\DTOs;

use Src\Features\Paie\Domain\ValueObjects\CnpsBreakdown;
use Src\Features\Paie\Domain\ValueObjects\ItsCalculation;

class PayslipSummaryDTO
{
    public function __construct(
        public readonly int $salaireBase,
        public readonly int $totalBrut,
        public readonly int $totalPrimes,
        public readonly int $totalIndemnites,
        public readonly int $heuresSupJour,
        public readonly int $heuresSupNuit,
        public readonly CnpsBreakdown $cnps,
        public readonly ItsCalculation $its,
        public readonly int $netAPayer,
    ) {}

    public function toArray(): array
    {
        return array_merge([
            'salaire_base' => $this->salaireBase,
            'total_brut' => $this->totalBrut,
            'total_primes' => $this->totalPrimes,
            'total_indemnites' => $this->totalIndemnites,
            'heures_sup_jour' => $this->heuresSupJour,
            'heures_sup_nuit' => $this->heuresSupNuit,
            'net_a_payer' => $this->netAPayer,
        ], $this->cnps->toArray(), $this->its->toArray());
    }
}
