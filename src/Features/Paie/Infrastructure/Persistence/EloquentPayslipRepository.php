<?php

namespace Src\Features\Paie\Infrastructure\Persistence;

use App\Models\Paie\Payslip;
use Src\Features\Paie\Domain\Contracts\PayslipRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class EloquentPayslipRepository implements PayslipRepositoryInterface
{
    public function findById(int $id): ?Payslip
    {
        return Payslip::find($id);
    }

    public function findByIdAndTenant(int $id, int $tenantId): ?Payslip
    {
        return Payslip::where('tenant_id', $tenantId)->find($id);
    }

    public function findExisting(int $employeeId, int $mois, int $annee): ?Payslip
    {
        return Payslip::where('employee_id', $employeeId)
            ->where('mois', $mois)
            ->where('annee', $annee)
            ->first();
    }

    public function paginated(int $tenantId, array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Payslip::where('tenant_id', $tenantId)->with('employee');

        if (!empty($filters['mois'])) {
            $query->where('mois', $filters['mois']);
        }

        if (!empty($filters['annee'])) {
            $query->where('annee', $filters['annee']);
        }

        if (!empty($filters['statut'])) {
            $query->where('statut', $filters['statut']);
        }

        if (!empty($filters['employee_id'])) {
            $query->where('employee_id', $filters['employee_id']);
        }

        return $query->orderByDesc('annee')->orderByDesc('mois')->paginate($perPage);
    }

    public function findByPeriod(int $mois, int $annee, int $tenantId): Collection
    {
        return Payslip::where('tenant_id', $tenantId)
            ->where('mois', $mois)
            ->where('annee', $annee)
            ->with('employee')
            ->get();
    }

    public function countByTenant(int $tenantId): int
    {
        return Payslip::where('tenant_id', $tenantId)->count();
    }

    public function sumNetByPeriod(int $mois, int $annee, int $tenantId): int
    {
        return Payslip::where('tenant_id', $tenantId)
            ->where('mois', $mois)
            ->where('annee', $annee)
            ->sum('net_a_payer');
    }

    public function save(Payslip $payslip): bool
    {
        return $payslip->save();
    }

    public function delete(Payslip $payslip): bool
    {
        return $payslip->delete();
    }
}
