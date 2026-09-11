<?php

namespace Src\Features\Paie\Domain\Contracts;

use App\Models\Paie\Timesheet;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TimesheetRepositoryInterface
{
    public function findById(int $id): ?Timesheet;

    public function findByIdAndTenant(int $id, int $tenantId): ?Timesheet;

    public function paginated(int $tenantId, array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function findByEmployeeAndDate(int $employeeId, string $date): ?Timesheet;

    public function save(Timesheet $timesheet): bool;

    public function delete(Timesheet $timesheet): bool;
}
