<?php

namespace Src\Features\Paie\Domain\Contracts;

use App\Models\Paie\Payslip;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PayslipRepositoryInterface
{
    public function findById(int $id): ?Payslip;

    public function findByIdAndTenant(int $id, int $tenantId): ?Payslip;

    public function findExisting(int $employeeId, int $mois, int $annee): ?Payslip;

    public function paginated(int $tenantId, array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function findByPeriod(int $mois, int $annee, int $tenantId): \Illuminate\Database\Eloquent\Collection;

    public function countByTenant(int $tenantId): int;

    public function sumNetByPeriod(int $mois, int $annee, int $tenantId): int;

    public function save(Payslip $payslip): bool;

    public function delete(Payslip $payslip): bool;
}
