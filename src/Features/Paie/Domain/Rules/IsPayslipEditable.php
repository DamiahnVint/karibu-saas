<?php

namespace Src\Features\Paie\Domain\Rules;

use App\Models\Paie\Payslip;
use App\Enums\Paie\PayslipStatus;

/**
 * Verifie si un bulletin de paie peut etre modifie (seul le brouillon est editable).
 */
class IsPayslipEditable
{
    public function evaluate(Payslip $payslip): bool
    {
        return $payslip->status()->isEditable();
    }

    public function message(): string
    {
        return 'Ce bulletin ne peut plus être modifié (statut validé ou payé).';
    }
}
