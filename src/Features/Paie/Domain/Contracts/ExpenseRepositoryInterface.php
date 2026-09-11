<?php

namespace Src\Features\Paie\Domain\Contracts;

use App\Models\Paie\Expense;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ExpenseRepositoryInterface
{
    public function findById(int $id): ?Expense;

    public function findByIdAndTenant(int $id, int $tenantId): ?Expense;

    public function paginated(int $tenantId, array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function save(Expense $expense): bool;

    public function delete(Expense $expense): bool;
}
