<?php

namespace Src\Features\Paie\Application\Actions\Expense;

use App\Models\Paie\Expense;
use Src\Features\Paie\Domain\Contracts\ExpenseRepositoryInterface;

class ApproveExpenseAction
{
    public function __construct(
        private ExpenseRepositoryInterface $repository,
    ) {}

    public function execute(int $expenseId, int $approvedBy, bool $approved): Expense
    {
        $expense = $this->repository->findById($expenseId);

        if (!$expense) {
            throw new \DomainException('Note de frais introuvable.');
        }

        if ($expense->statut !== 'en_attente') {
            throw new \DomainException('Cette note de frais a déjà été traitée.');
        }

        $expense->statut = $approved ? 'approuve' : 'rejette';
        $expense->approuve_par = $approvedBy;

        $this->repository->save($expense);

        return $expense;
    }
}
