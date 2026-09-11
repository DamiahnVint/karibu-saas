<?php

namespace Src\Features\Paie\Application\Actions\Leave;

use App\Models\Paie\Leave;
use App\Models\Paie\LeaveBalance;
use Src\Features\Paie\Application\DTOs\StoreLeaveDTO;
use Src\Features\Paie\Domain\Contracts\LeaveRepositoryInterface;
use Src\Features\Paie\Domain\Rules\CannotOverlapLeaves;
use Src\Features\Paie\Domain\Rules\IsLeaveBalanceSufficient;
use App\Models\Paie\Employee;

class StoreLeaveAction
{
    public function __construct(
        private LeaveRepositoryInterface $repository,
    ) {}

    public function execute(StoreLeaveDTO $dto): Leave
    {
        $employee = Employee::findOrFail($dto->employeeId);

        // Verification chevauchement
        $overlapRule = new CannotOverlapLeaves();
        if (!$overlapRule->evaluate($employee, $dto->dateDebut, $dto->dateFin)) {
            throw new \DomainException($overlapRule->message());
        }

        // Verification solde
        $balanceRule = new IsLeaveBalanceSufficient();
        if (!$balanceRule->evaluate($employee, $dto->type, $dto->nbJours, (int) now()->year)) {
            throw new \DomainException($balanceRule->message());
        }

        $leave = new Leave();
        $leave->employee_id = $dto->employeeId;
        $leave->type = $dto->type;
        $leave->date_debut = $dto->dateDebut;
        $leave->date_fin = $dto->dateFin;
        $leave->nb_jours = $dto->nbJours;
        $leave->motif = $dto->motif;
        $leave->statut = 'en_attente';
        $leave->notes = $dto->notes;

        $this->repository->save($leave);

        return $leave;
    }
}
