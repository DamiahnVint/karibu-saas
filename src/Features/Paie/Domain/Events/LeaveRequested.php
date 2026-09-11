<?php

namespace Src\Features\Paie\Domain\Events;

use App\Models\Paie\Leave;

class LeaveRequested
{
    public function __construct(
        public readonly Leave $leave,
        public readonly int $tenantId,
    ) {}
}
