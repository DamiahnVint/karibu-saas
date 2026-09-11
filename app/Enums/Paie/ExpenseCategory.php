<?php

namespace App\Enums\Paie;

enum ExpenseCategory: string
{
    case TRANSPORT = 'transport';
    case HEBERGEMENT = 'hebergement';
    case REPAS = 'repas';
    case FOURNITURES = 'fournitures';
    case AUTRE = 'autre';

    public function label(): string
    {
        return match ($this) {
            self::TRANSPORT => 'Transport',
            self::HEBERGEMENT => 'Hébergement',
            self::REPAS => 'Repas',
            self::FOURNITURES => 'Fournitures',
            self::AUTRE => 'Autre',
        };
    }
}
