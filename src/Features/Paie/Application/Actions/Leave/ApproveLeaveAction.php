<?php

namespace Src\Features\Paie\Application\Actions\Leave;

use App\Models\Paie\Leave;
use App\Models\Paie\LeaveBalance;
use Src\Features\Paie\Domain\Contracts\LeaveRepositoryInterface;

class ApproveLeaveAction
{
    public function __construct(
        private LeaveRepositoryInterface $repository,
    ) {}

    public function execute(int $leaveId, int $approvedBy, bool $approved): Leave
    {
        $leave = $this->repository->findById($leaveId);

        if (!$leave) {
            throw new \DomainException('Demande de congé introuvable.');
        }

        if ($leave->statut !== 'en_attente') {
            throw new \DomainException('Cette demande de congé a déjà été traitée.');
        }

        $leave->statut = $approved ? 'approuve' : 'rejette';
        $leave->approuve_par = $approvedBy;
        $leave->approuve_le = now();

        $this->repository->save($leave);

        // Si approuve, mettre a jour le solde
        if ($approved && $leave->isPaid()) {
            $annee = $leave->date_debut->year;
            $balance = LeaveBalance::where('employee_id', $leave->employee_id)
                ->where('type', $leave->type)
                ->where('annee', $annee)
                ->first();

            if ($balance) {
                $balance->utilise += $leave->nb_jours;
                $balance->reste = max(0, $balance->total - $balance->utilise);
                $balance->save();
            }
        }

        return $leave;
    }
}
