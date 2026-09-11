<?php

namespace Src\Features\Paie\Application\Actions\Expense;

use App\Models\Paie\Expense;
use Src\Features\Paie\Application\DTOs\StoreExpenseDTO;
use Src\Features\Paie\Domain\Contracts\ExpenseRepositoryInterface;

class StoreExpenseAction
{
    public function __construct(
        private ExpenseRepositoryInterface $repository,
    ) {}

    public function execute(StoreExpenseDTO $dto): Expense
    {
        $expense = new Expense();
        $expense->employee_id = $dto->employeeId;
        $expense->date = $dto->date;
        $expense->categorie = $dto->categorie;
        $expense->montant = $dto->montant;
        $expense->description = $dto->description;
        $expense->justificatif_path = $dto->justificatifPath;
        $expense->statut = 'en_attente';
        $expense->notes = $dto->notes;

        $this->repository->save($expense);

        return $expense;
    }
}
