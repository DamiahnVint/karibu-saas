<?php

namespace Src\Features\Paie\Domain\Contracts;

use App\Models\Paie\Leave;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface LeaveRepositoryInterface
{
    public function findById(int $id): ?Leave;

    public function findByIdAndTenant(int $id, int $tenantId): ?Leave;

    public function paginated(int $tenantId, array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function findByEmployee(int $employeeId): \Illuminate\Database\Eloquent\Collection;

    public function findOverlapping(int $employeeId, string $dateDebut, string $dateFin, ?int $excludeId = null): ?Leave;

    public function save(Leave $leave): bool;

    public function delete(Leave $leave): bool;
}
