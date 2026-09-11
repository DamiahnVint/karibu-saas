<?php

namespace Src\Features\Paie\Infrastructure\Persistence;

use App\Models\Paie\Expense;
use Src\Features\Paie\Domain\Contracts\ExpenseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentExpenseRepository implements ExpenseRepositoryInterface
{
    public function findById(int $id): ?Expense
    {
        return Expense::find($id);
    }

    public function findByIdAndTenant(int $id, int $tenantId): ?Expense
    {
        return Expense::whereHas('employee', fn ($q) => $q->where('tenant_id', $tenantId))->find($id);
    }

    public function paginated(int $tenantId, array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Expense::whereHas('employee', fn ($q) => $q->where('tenant_id', $tenantId))
            ->with('employee');

        if (!empty($filters['statut'])) {
            $query->where('statut', $filters['statut']);
        }

        if (!empty($filters['categorie'])) {
            $query->where('categorie', $filters['categorie']);
        }

        if (!empty($filters['employee_id'])) {
            $query->where('employee_id', $filters['employee_id']);
        }

        return $query->orderByDesc('date')->paginate($perPage);
    }

    public function save(Expense $expense): bool
    {
        return $expense->save();
    }

    public function delete(Expense $expense): bool
    {
        return $expense->delete();
    }
}
