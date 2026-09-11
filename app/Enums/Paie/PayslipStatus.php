<?php

namespace App\Enums\Paie;

enum PayslipStatus: string
{
    case BROUILLON = 'brouillon';
    case VALIDE = 'valide';
    case PAYE = 'paye';

    public function label(): string
    {
        return match ($this) {
            self::BROUILLON => 'Brouillon',
            self::VALIDE => 'Validé',
            self::PAYE => 'Payé',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::BROUILLON => 'gray',
            self::VALIDE => 'blue',
            self::PAYE => 'green',
        };
    }

    public function isEditable(): bool
    {
        return $this === self::BROUILLON;
    }
}
