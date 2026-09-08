<?php

namespace App\Enums;

enum TenantPlan: string
{
    case FREE = 'free';
    case ESSENTIEL = 'essentiel';
    case PROFESSIONNEL = 'professionnel';
    case ENTERPRISE = 'enterprise';

    public function label(): string
    {
        return match($this) {
            self::FREE => 'Gratuit (14 jours)',
            self::ESSENTIEL => 'Essentiel',
            self::PROFESSIONNEL => 'Professionnel',
            self::ENTERPRISE => 'Enterprise',
        };
    }

    public function price(): int
    {
        return match($this) {
            self::FREE => 0,
            self::ESSENTIEL => 25000,
            self::PROFESSIONNEL => 45000,
            self::ENTERPRISE => 0, // Sur mesure
        };
    }

    public function maxEmployees(): int
    {
        return match($this) {
            self::FREE => 5,
            self::ESSENTIEL => 25,
            self::PROFESSIONNEL => 100,
            self::ENTERPRISE => 999999,
        };
    }

    public function features(): array
    {
        return match($this) {
            self::FREE => [
                'Jusqu\'à 5 employés',
                'Génération de bulletins',
                'Calcul CNPS + ITS',
                'Support par email',
            ],
            self::ESSENTIEL => [
                'Jusqu\'à 25 employés',
                'Tout du plan Gratuit',
                'Déclarations CNPS',
                'Export PDF',
                'Support prioritaire',
            ],
            self::PROFESSIONNEL => [
                'Jusqu\'à 100 employés',
                'Tout du plan Essentiel',
                'Module RH complet',
                'Multi-utilisateurs',
                'API access',
                'Support dédié',
            ],
            self::ENTERPRISE => [
                'Employés illimités',
                'Tout du plan Professionnel',
                'Déploiement dédié',
                'Intégration sur mesure',
                'Support 24/7',
                'SLA garanti',
            ],
        };
    }
}
