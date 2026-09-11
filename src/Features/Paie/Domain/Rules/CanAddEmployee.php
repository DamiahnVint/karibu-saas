<?php

namespace Src\Features\Paie\Domain\Rules;

use App\Models\Paie\Employee;
use App\Models\Tenant;

/**
 * Verifie si un employe peut etre ajoute au tenant (limite du plan).
 */
class CanAddEmployee
{
    public function evaluate(Employee $employee, Tenant $tenant): bool
    {
        return $tenant->canAddEmployee();
    }

    public function message(): string
    {
        return 'Limite d\'employés atteinte pour votre plan. Passez à un plan supérieur.';
    }
}
