<?php

namespace App\Enums\Paie;

enum LeaveStatut: string
{
    case EN_ATTENTE = 'en_attente';
    case APPROUVE = 'approuve';
    case REJETTE = 'rejette';

    public function label(): string
    {
        return match ($this) {
            self::EN_ATTENTE => 'En attente',
            self::APPROUVE => 'Approuvé',
            self::REJETTE => 'Rejeté',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::EN_ATTENTE => 'amber',
            self::APPROUVE => 'green',
            self::REJETTE => 'red',
        };
    }
}
