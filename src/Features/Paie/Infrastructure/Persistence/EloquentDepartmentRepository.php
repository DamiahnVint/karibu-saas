<?php

namespace Src\Features\Paie\Infrastructure\Persistence;

use App\Models\Paie\Department;
use Src\Features\Paie\Domain\Contracts\DepartmentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EloquentDepartmentRepository implements DepartmentRepositoryInterface
{
    public function findById(int $id): ?Department
    {
        return Department::find($id);
    }

    public function findByIdAndTenant(int $id, int $tenantId): ?Department
    {
        return Department::where('tenant_id', $tenantId)->find($id);
    }

    public function allByTenant(int $tenantId): Collection
    {
        return Department::where('tenant_id', $tenantId)
            ->with('children')
            ->orderBy('name')
            ->get();
    }

    public function save(Department $department): bool
    {
        return $department->save();
    }

    public function delete(Department $department): bool
    {
        return $department->delete();
    }
}
