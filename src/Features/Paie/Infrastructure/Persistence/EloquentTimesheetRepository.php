<?php

namespace Src\Features\Paie\Infrastructure\Persistence;

use App\Models\Paie\Timesheet;
use Src\Features\Paie\Domain\Contracts\TimesheetRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentTimesheetRepository implements TimesheetRepositoryInterface
{
    public function findById(int $id): ?Timesheet
    {
        return Timesheet::find($id);
    }

    public function findByIdAndTenant(int $id, int $tenantId): ?Timesheet
    {
        return Timesheet::whereHas('employee', fn ($q) => $q->where('tenant_id', $tenantId))->find($id);
    }

    public function paginated(int $tenantId, array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Timesheet::whereHas('employee', fn ($q) => $q->where('tenant_id', $tenantId))
            ->with('employee');

        if (!empty($filters['employee_id'])) {
            $query->where('employee_id', $filters['employee_id']);
        }

        if (!empty($filters['date_from'])) {
            $query->where('date', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('date', '<=', $filters['date_to']);
        }

        return $query->orderByDesc('date')->paginate($perPage);
    }

    public function findByEmployeeAndDate(int $employeeId, string $date): ?Timesheet
    {
        return Timesheet::where('employee_id', $employeeId)->where('date', $date)->first();
    }

    public function save(Timesheet $timesheet): bool
    {
        return $timesheet->save();
    }

    public function delete(Timesheet $timesheet): bool
    {
        return $timesheet->delete();
    }
}
