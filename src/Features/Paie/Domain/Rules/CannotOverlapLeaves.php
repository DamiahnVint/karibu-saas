<?php

namespace Src\Features\Paie\Domain\Rules;

use App\Models\Paie\Leave;
use App\Models\Paie\Employee;

/**
 * Verifie si des conges se chevauchent pour un meme employe.
 */
class CannotOverlapLeaves
{
    public function evaluate(Employee $employee, string $dateDebut, string $dateFin, ?int $excludeId = null): bool
    {
        $query = Leave::where('employee_id', $employee->id)
            ->whereIn('statut', ['en_attente', 'approuve'])
            ->where(function ($q) use ($dateDebut, $dateFin) {
                $q->whereBetween('date_debut', [$dateDebut, $dateFin])
                    ->orWhereBetween('date_fin', [$dateDebut, $dateFin])
                    ->orWhere(function ($q2) use ($dateDebut, $dateFin) {
                        $q2->where('date_debut', '<=', $dateDebut)
                            ->where('date_fin', '>=', $dateFin);
                    });
            });

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return !$query->exists();
    }

    public function message(): string
    {
        return 'Ces dates de congé chevauchent un congé existant.';
    }
}
