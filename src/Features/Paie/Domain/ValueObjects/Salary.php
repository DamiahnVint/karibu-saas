<?php

namespace Src\Features\Paie\Domain\ValueObjects;

/**
 * Represente le detail du calcul d'un salaire (brut, deductions, net).
 * Utilise pour le simulateur et les rapports.
 */
class Salary
{
    public function __construct(
        public readonly int $base,
        public readonly int $primes = 0,
        public readonly int $indemnites = 0,
        public readonly int $heuresSupJour = 0,
        public readonly int $heuresSupNuit = 0,
        public readonly int $avantagesNature = 0,
        public readonly int $brut = 0,
        public readonly int $cnpsSalarie = 0,
        public readonly int $its = 0,
        public readonly int $net = 0,
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            base: $data['salaire_base'] ?? 0,
            primes: $data['total_primes'] ?? 0,
            indemnites: $data['total_indemnites'] ?? 0,
            heuresSupJour: $data['heures_sup_jour'] ?? 0,
            heuresSupNuit: $data['heures_sup_nuit'] ?? 0,
            avantagesNature: $data['avantages_nature'] ?? 0,
            brut: $data['total_brut'] ?? 0,
            cnpsSalarie: $data['total_cnps_salarie'] ?? 0,
            its: $data['its_net'] ?? 0,
            net: $data['net_a_payer'] ?? 0,
        );
    }

    public function toArray(): array
    {
        return [
            'salaire_base' => $this->base,
            'total_primes' => $this->primes,
            'total_indemnites' => $this->indemnites,
            'heures_sup_jour' => $this->heuresSupJour,
            'heures_sup_nuit' => $this->heuresSupNuit,
            'avantages_nature' => $this->avantagesNature,
            'total_brut' => $this->brut,
            'total_cnps_salarie' => $this->cnpsSalarie,
            'its_net' => $this->its,
            'net_a_payer' => $this->net,
        ];
    }
}
