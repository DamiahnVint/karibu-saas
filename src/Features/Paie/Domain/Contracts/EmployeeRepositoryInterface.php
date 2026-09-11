<?php

namespace Src\Features\Paie\Domain\Contracts;

use App\Models\Paie\Employee;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface EmployeeRepositoryInterface
{
    public function findById(int $id): ?Employee;

    public function findByIdAndTenant(int $id, int $tenantId): ?Employee;

    public function findByMatricule(string $matricule, int $tenantId): ?Employee;

    public function paginated(int $tenantId, array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function countByTenant(int $tenantId): int;

    public function countActiveByTenant(int $tenantId): int;

    public function nextMatricule(int $tenantId): string;

    public function save(Employee $employee): bool;

    public function delete(Employee $employee): bool;
}
