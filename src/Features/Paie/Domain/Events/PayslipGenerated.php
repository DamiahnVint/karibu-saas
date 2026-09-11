<?php

namespace Src\Features\Paie\Domain\Events;

use App\Models\Paie\Payslip;

class PayslipGenerated
{
    public function __construct(
        public readonly Payslip $payslip,
        public readonly int $tenantId,
    ) {}
}
