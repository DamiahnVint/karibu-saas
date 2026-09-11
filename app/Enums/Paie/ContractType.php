<?php

namespace App\Enums\Paie;

enum ContractType: string
{
    case CDI = 'cdi';
    case CDD = 'cdd';
    case SAISONNIER = 'saisonnier';
    case STAGE = 'stage';

    public function label(): string
    {
        return match ($this) {
            self::CDI => 'CDI',
            self::CDD => 'CDD',
            self::SAISONNIER => 'Saisonnier',
            self::STAGE => 'Stage',
        };
    }
}
