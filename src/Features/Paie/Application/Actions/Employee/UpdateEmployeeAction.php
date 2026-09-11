<?php

namespace Src\Features\Paie\Application\Actions\Employee;

use App\Models\Paie\Employee;
use Src\Features\Paie\Application\DTOs\StoreEmployeeDTO;
use Src\Features\Paie\Domain\Contracts\EmployeeRepositoryInterface;

class UpdateEmployeeAction
{
    public function __construct(
        private EmployeeRepositoryInterface $repository,
    ) {}

    public function execute(int $id, int $tenantId, StoreEmployeeDTO $dto): Employee
    {
        $employee = $this->repository->findByIdAndTenant($id, $tenantId);

        if (!$employee) {
            throw new \DomainException('Employé introuvable.');
        }

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

        return $employee;
    }
}
