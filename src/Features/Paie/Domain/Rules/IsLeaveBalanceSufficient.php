<?php

namespace Src\Features\Paie\Domain\Rules;

use App\Models\Paie\Employee;
use App\Models\Paie\LeaveBalance;
use App\Enums\Paie\LeaveType;

/**
 * Verifie si l'employe a un solde de conges suffisant.
 */
class IsLeaveBalanceSufficient
{
    public function evaluate(Employee $employee, string $type, int $nbJours, int $annee): bool
    {
        $leaveType = LeaveType::tryFrom($type);

        // Les conges sans solde, deces, mariage, naissance n'impacteront pas le solde paye
        if ($leaveType && !$leaveType->isPaid()) {
            return true;
        }

        // Pour les conges payes/maladie/maternite/paternite, verifier le solde
        $balance = LeaveBalance::where('employee_id', $employee->id)
            ->where('type', $type)
            ->where('annee', $annee)
            ->first();

        if (!$balance) {
            return false;
        }

        return $balance->reste >= $nbJours;
    }

    public function message(): string
    {
        return 'Solde de congés insuffisant.';
    }
}
