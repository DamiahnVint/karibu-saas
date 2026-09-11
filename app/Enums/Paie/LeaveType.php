<?php

namespace App\Enums\Paie;

enum LeaveType: string
{
    case PAYE = 'paye';
    case MALADIE = 'maladie';
    case MATERNITE = 'maternite';
    case PATERNITE = 'paternite';
    case SANS_SOLDE = 'sans_solde';
    case DECES = 'deces';
    case MARIAGE = 'mariage';
    case NAISSANCE = 'naissance';

    public function label(): string
    {
        return match ($this) {
            self::PAYE => 'Congé payé',
            self::MALADIE => 'Congé maladie',
            self::MATERNITE => 'Congé maternité',
            self::PATERNITE => 'Congé paternité',
            self::SANS_SOLDE => 'Congé sans solde',
            self::DECES => 'Congé décès',
            self::MARIAGE => 'Congé mariage',
            self::NAISSANCE => 'Congé naissance',
        };
    }

    public function isPaid(): bool
    {
        return in_array($this, [self::PAYE, self::MALADIE, self::MATERNITE, self::PATERNITE, self::DECES, self::MARIAGE, self::NAISSANCE]);
    }
}
