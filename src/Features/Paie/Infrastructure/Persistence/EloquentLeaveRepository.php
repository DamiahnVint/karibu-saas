<?php

namespace Src\Features\Paie\Infrastructure\Persistence;

use App\Models\Paie\Leave;
use Src\Features\Paie\Domain\Contracts\LeaveRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class EloquentLeaveRepository implements LeaveRepositoryInterface
{
    public function findById(int $id): ?Leave
    {
        return Leave::find($id);
    }

    public function findByIdAndTenant(int $id, int $tenantId): ?Leave
    {
        return Leave::whereHas('employee', fn ($q) => $q->where('tenant_id', $tenantId))->find($id);
    }

    public function paginated(int $tenantId, array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Leave::whereHas('employee', fn ($q) => $q->where('tenant_id', $tenantId))
            ->with('employee');

        if (!empty($filters['statut'])) {
            $query->where('statut', $filters['statut']);
        }

        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (!empty($filters['employee_id'])) {
            $query->where('employee_id', $filters['employee_id']);
        }

        return $query->orderByDesc('created_at')->paginate($perPage);
    }

    public function findByEmployee(int $employeeId): Collection
    {
        return Leave::where('employee_id', $employeeId)->orderByDesc('date_debut')->get();
    }

    public function findOverlapping(int $employeeId, string $dateDebut, string $dateFin, ?int $excludeId = null): ?Leave
    {
        $query = Leave::where('employee_id', $employeeId)
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

        return $query->first();
    }

    public function save(Leave $leave): bool
    {
        return $leave->save();
    }

    public function delete(Leave $leave): bool
    {
        return $leave->delete();
    }
}
