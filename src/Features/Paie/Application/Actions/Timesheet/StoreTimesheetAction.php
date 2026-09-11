<?php

namespace Src\Features\Paie\Application\Actions\Timesheet;

use App\Models\Paie\Timesheet;
use Src\Features\Paie\Application\DTOs\StoreTimesheetDTO;
use Src\Features\Paie\Domain\Contracts\TimesheetRepositoryInterface;

class StoreTimesheetAction
{
    public function __construct(
        private TimesheetRepositoryInterface $repository,
    ) {}

    public function execute(StoreTimesheetDTO $dto): Timesheet
    {
        // Verifier doublon
        $existing = $this->repository->findByEmployeeAndDate($dto->employeeId, $dto->date);
        if ($existing) {
            throw new \DomainException('Une feuille de temps existe déjà pour cette date.');
        }

        $timesheet = new Timesheet();
        $timesheet->employee_id = $dto->employeeId;
        $timesheet->date = $dto->date;
        $timesheet->heure_debut = $dto->heureDebut;
        $timesheet->heure_fin = $dto->heureFin;
        $timesheet->pause = $dto->pause;
        $timesheet->statut = 'brouillon';
        $timesheet->notes = $dto->notes;

        // Calculer les heures
        $timesheet->calculerHeures();

        $this->repository->save($timesheet);

        return $timesheet;
    }
}
