<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\Paie\Department;
use App\Models\Paie\Employee;
use App\Models\Paie\LeaveBalance;
use Illuminate\Database\Seeder;

class PaieSeeder extends Seeder
{
    public function run(): void
    {
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            // Departements par defaut
            $departments = ['Direction', 'Finance', 'Ressources Humaines', 'Informatique', 'Commercial', 'Production'];
            $createdDepts = [];

            foreach ($departments as $deptName) {
                $dept = Department::create([
                    'tenant_id' => $tenant->id,
                    'name' => $deptName,
                    'description' => "Département {$deptName}",
                ]);
                $createdDepts[] = $dept;
            }

            // Employes de test (5 employes)
            $employees = [
                ['nom' => 'DIALLO', 'prenom' => 'Amadou', 'sexe' => 'M', 'situation_familiale' => 'marie', 'nb_enfants' => 3, 'poste' => 'Directeur Général', 'salaire_base' => 2500000, 'type_contrat' => 'cdi'],
                ['nom' => 'KONE', 'prenom' => 'Fatou', 'sexe' => 'F', 'situation_familiale' => 'celibataire', 'nb_enfants' => 0, 'poste' => 'Comptable', 'salaire_base' => 750000, 'type_contrat' => 'cdi'],
                ['nom' => 'TOURE', 'prenom' => 'Ibrahim', 'sexe' => 'M', 'situation_familiale' => 'marie', 'nb_enfants' => 2, 'poste' => 'Développeur Senior', 'salaire_base' => 1000000, 'type_contrat' => 'cdi'],
                ['nom' => 'OUATTARA', 'prenom' => 'Awa', 'sexe' => 'F', 'situation_familiale' => 'marie', 'nb_enfants' => 1, 'poste' => 'Chargée RH', 'salaire_base' => 600000, 'type_contrat' => 'cdi'],
                ['nom' => 'BAMBA', 'prenom' => 'Moussa', 'sexe' => 'M', 'situation_familiale' => 'celibataire', 'nb_enfants' => 0, 'poste' => 'Commercial', 'salaire_base' => 400000, 'type_contrat' => 'cdd'],
            ];

            foreach ($employees as $index => $empData) {
                $employee = Employee::create(array_merge($empData, [
                    'tenant_id' => $tenant->id,
                    'date_embauche' => now()->subMonths(12 + $index),
                    'department_id' => $createdDepts[$index % count($createdDepts)]->id,
                    'mode_paiement' => 'virement',
                    'statut' => 'actif',
                ]));

                // Solde de conges par defaut (30 jours/an)
                LeaveBalance::create([
                    'employee_id' => $employee->id,
                    'type' => 'paye',
                    'annee' => (int) now()->year,
                    'total' => 30,
                    'utilise' => 0,
                    'reste' => 30,
                ]);
            }
        }

        $this->command->info("PaieSeeder: Départements et employés de test créés pour " . $tenants->count() . " tenant(s).");
    }
}
