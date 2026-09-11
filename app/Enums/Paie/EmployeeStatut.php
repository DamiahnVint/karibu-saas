<?php

namespace App\Enums\Paie;

enum EmployeeStatut: string
{
    case ACTIF = 'actif';
    case INACTIF = 'inactif';
    case SUSPENDU = 'suspendu';
    case RADIE = 'radie';

    public function label(): string
    {
        return match ($this) {
            self::ACTIF => 'Actif',
            self::INACTIF => 'Inactif',
            self::SUSPENDU => 'Suspendu',
            self::RADIE => 'Radié',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::ACTIF => 'green',
            self::INACTIF => 'gray',
            self::SUSPENDU => 'amber',
            self::RADIE => 'red',
        };
    }
}
