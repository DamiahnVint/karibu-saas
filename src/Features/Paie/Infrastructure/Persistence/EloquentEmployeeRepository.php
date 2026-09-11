<?php

namespace Src\Features\Paie\Infrastructure\Persistence;

use App\Models\Paie\Employee;
use Src\Features\Paie\Domain\Contracts\EmployeeRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentEmployeeRepository implements EmployeeRepositoryInterface
{
    public function findById(int $id): ?Employee
    {
        return Employee::find($id);
    }

    public function findByIdAndTenant(int $id, int $tenantId): ?Employee
    {
        return Employee::where('tenant_id', $tenantId)->find($id);
    }

    public function findByMatricule(string $matricule, int $tenantId): ?Employee
    {
        return Employee::where('tenant_id', $tenantId)->where('matricule', $matricule)->first();
    }

    public function paginated(int $tenantId, array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Employee::where('tenant_id', $tenantId)->with('department');

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                    ->orWhere('prenom', 'like', "%{$search}%")
                    ->orWhere('matricule', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['statut'])) {
            $query->where('statut', $filters['statut']);
        }

        if (!empty($filters['department_id'])) {
            $query->where('department_id', $filters['department_id']);
        }

        return $query->orderBy('nom')->paginate($perPage);
    }

    public function countByTenant(int $tenantId): int
    {
        return Employee::where('tenant_id', $tenantId)->count();
    }

    public function countActiveByTenant(int $tenantId): int
    {
        return Employee::where('tenant_id', $tenantId)->where('statut', 'actif')->count();
    }

    public function nextMatricule(int $tenantId): string
    {
        return Employee::generateMatricule($tenantId);
    }

    public function save(Employee $employee): bool
    {
        return $employee->save();
    }

    public function delete(Employee $employee): bool
    {
        return $employee->delete();
    }
}
