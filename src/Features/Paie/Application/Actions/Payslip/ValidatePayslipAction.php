<?php

namespace Src\Features\Paie\Application\Actions\Payslip;

use App\Models\Paie\Payslip;
use Src\Features\Paie\Domain\Contracts\PayslipRepositoryInterface;

class ValidatePayslipAction
{
    public function __construct(
        private PayslipRepositoryInterface $repository,
    ) {}

    public function execute(int $payslipId, int $tenantId, int $userId): Payslip
    {
        $payslip = $this->repository->findByIdAndTenant($payslipId, $tenantId);

        if (!$payslip) {
            throw new \DomainException('Bulletin introuvable.');
        }

        if ($payslip->statut !== 'brouillon') {
            throw new \DomainException('Seuls les bulletins en brouillon peuvent être validés.');
        }

        $payslip->statut = 'valide';
        $payslip->valide_par = $userId;
        $payslip->valide_le = now();

        $this->repository->save($payslip);

        return $payslip;
    }
}
