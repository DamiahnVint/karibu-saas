<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Essentiel',
                'slug' => 'essentiel',
                'description' => 'Pour les petites entreprises qui démarrent leur gestion de paie.',
                'price' => 20000,
                'currency' => 'XOF',
                'billing_cycle' => 'monthly',
                'max_employees' => 15,
                'features' => [
                    'Calcul de paie automatisé (CNPS, ITS, CMU)',
                    'Bulletins de paie PDF',
                    'Jusqu\'à 15 employés',
                    '1 utilisateur admin',
                    'Déclarations sociales',
                    'Support par email',
                ],
                'is_active' => true,
                'is_trial' => false,
                'trial_days' => 15,
                'sort_order' => 1,
            ],
            [
                'name' => 'Professionnel',
                'slug' => 'professionnel',
                'description' => 'Pour les entreprises en croissance avec des besoins avancés.',
                'price' => 35000,
                'currency' => 'XOF',
                'billing_cycle' => 'monthly',
                'max_employees' => 50,
                'features' => [
                    'Tout le plan Essentiel',
                    'Jusqu\'à 50 employés',
                    '3 utilisateurs',
                    'Gestion des congés & absences',
                    'Organigramme',
                    'Solde de tout compte (STC)',
                    'Historique des paies',
                    'Support prioritaire',
                ],
                'is_active' => true,
                'is_trial' => false,
                'trial_days' => 15,
                'sort_order' => 2,
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'description' => 'Pour les grandes entreprises avec des besoins sur mesure.',
                'price' => 0,
                'currency' => 'XOF',
                'billing_cycle' => 'monthly',
                'max_employees' => 9999,
                'features' => [
                    'Tout le plan Professionnel',
                    'Employés illimités',
                    'Utilisateurs illimités',
                    'API développeurs',
                    'Intégration sur mesure',
                    'Support dédié',
                    'Formation incluse',
                    'SLA garanti',
                ],
                'is_active' => true,
                'is_trial' => false,
                'trial_days' => 15,
                'sort_order' => 3,
            ],
            [
                'name' => 'Essai Gratuit',
                'slug' => 'trial',
                'description' => 'Découvrez Karibu Paie pendant 15 jours, sans engagement.',
                'price' => 0,
                'currency' => 'XOF',
                'billing_cycle' => 'monthly',
                'max_employees' => 5,
                'features' => [
                    'Accès complet à toutes les fonctionnalités',
                    'Jusqu\'à 5 employés',
                    '1 utilisateur',
                    '15 jours d\'essai',
                    'Sans carte bancaire',
                ],
                'is_active' => true,
                'is_trial' => true,
                'trial_days' => 15,
                'sort_order' => 0,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::updateOrCreate(
                ['slug' => $plan['slug']],
                $plan
            );
        }
    }
}
