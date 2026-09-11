<?php

namespace Src\Features\Paie\Application\Actions\Employee;

use App\Models\Paie\Employee;
use App\Models\Paie\Contract;
use App\Models\Tenant;
use Src\Features\Paie\Application\DTOs\StoreEmployeeDTO;
use Src\Features\Paie\Domain\Contracts\EmployeeRepositoryInterface;
use Src\Features\Paie\Domain\Rules\CanAddEmployee;

class StoreEmployeeAction
{
    public function __construct(
        private EmployeeRepositoryInterface $repository,
    ) {}

    public function execute(StoreEmployeeDTO $dto): Employee
    {
        $tenant = Tenant::findOrFail($dto->tenantId);

        $rule = new CanAddEmployee();
        if (!$rule->evaluate(new Employee(), $tenant)) {
            throw new \DomainException($rule->message());
        }

        $employee = new Employee();
        $employee->tenant_id = $dto->tenantId;
        $employee->nom = $dto->nom;
        $employee->prenom = $dto->prenom;
        $employee->email = $dto->email;
        $employee->phone = $dto->phone;
        $employee->date_naissance = $dto->dateNaissance;
        $employee->sexe = $dto->sexe;
        $employee->situation_familiale = $dto->situationFamiliale;
        $employee->nb_enfants = $dto->nbEnfants;
        $employee->poste = $dto->poste;
        $employee->department_id = $dto->departmentId;
        $employee->date_embauche = $dto->dateEmbauche;
        $employee->type_contrat = $dto->typeContrat;
        $employee->duree_contrat = $dto->dureeContrat;
        $employee->salaire_base = $dto->salaireBase;
        $employee->mode_paiement = $dto->modePaiement;
        $employee->banque = $dto->banque;
        $employee->rib = $dto->rib;
        $employee->cnps_numero = $dto->cnpsNumero;
        $employee->statut = $dto->statut;
        $employee->notes = $dto->notes;

        $this->repository->save($employee);

        // Créer le contrat initial
        $contract = new Contract();
        $contract->employee_id = $employee->id;
        $contract->type_contrat = $dto->typeContrat;
        $contract->date_debut = $dto->dateEmbauche;
        $contract->date_fin = $dto->dureeContrat;
        $contract->salaire_base = $dto->salaireBase;
        $contract->poste = $dto->poste;
        $contract->motif = 'Embauche initiale';
        $contract->save();

        return $employee;
    }
}
