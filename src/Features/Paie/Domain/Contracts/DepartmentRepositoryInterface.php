<?php

namespace Src\Features\Paie\Domain\Contracts;

use App\Models\Paie\Department;
use Illuminate\Database\Eloquent\Collection;

interface DepartmentRepositoryInterface
{
    public function findById(int $id): ?Department;

    public function findByIdAndTenant(int $id, int $tenantId): ?Department;

    public function allByTenant(int $tenantId): Collection;

    public function save(Department $department): bool;

    public function delete(Department $department): bool;
}
