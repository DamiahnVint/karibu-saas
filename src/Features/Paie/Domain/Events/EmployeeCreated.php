<?php

namespace Src\Features\Paie\Domain\Events;

use App\Models\Paie\Employee;

class EmployeeCreated
{
    public function __construct(
        public readonly Employee $employee,
        public readonly int $tenantId,
    ) {}
}
