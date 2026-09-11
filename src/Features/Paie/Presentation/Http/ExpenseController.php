<?php

namespace Src\Features\Paie\Presentation\Http;

use App\Http\Controllers\Controller;
use App\Models\Paie\Employee;
use App\Models\Paie\Expense;
use Illuminate\Http\Request;
use Src\Features\Paie\Application\DTOs\StoreExpenseDTO;
use Src\Features\Paie\Application\Actions\Expense\StoreExpenseAction;
use Src\Features\Paie\Application\Actions\Expense\ApproveExpenseAction;
use Src\Features\Paie\Infrastructure\Persistence\EloquentExpenseRepository;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $tenantId = $request->user()->tenant_id;

        $repository = new EloquentExpenseRepository();
        $expenses = $repository->paginated($tenantId, $request->only(['statut', 'categorie', 'employee_id']), 15);

        return view('paie.expenses.index', compact('expenses'));
    }

    public function create(Request $request)
    {
        $tenantId = $request->user()->tenant_id;
        $employees = Employee::where('tenant_id', $tenantId)->where('statut', 'actif')->orderBy('nom')->get();

        return view('paie.expenses.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|integer|exists:paie_employees,id',
            'date' => 'required|date|before_or_equal:today',
            'categorie' => 'required|in:transport,hebergement,repas,fournitures,autre',
            'montant' => 'required|integer|min:1',
            'description' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:500',
        ]);

        $justificatifPath = null;
        if ($request->hasFile('justificatif')) {
            $justificatifPath = $request->file('justificatif')->store('expenses', 'public');
        }

        $dto = StoreExpenseDTO::fromarray(array_merge(
            $validated,
            ['tenant_id' => $request->user()->tenant_id, 'justificatif_path' => $justificatifPath]
        ));

        $action = new StoreExpenseAction(new EloquentExpenseRepository());
        $expense = $action->execute($dto);

        return redirect()->route('paie.expenses.index')
            ->with('success', 'Note de frais soumise avec succès.');
    }

    public function approve(Request $request, int $id)
    {
        $validated = $request->validate([
            'approved' => 'required|boolean',
        ]);

        $action = new ApproveExpenseAction(new EloquentExpenseRepository());
        $expense = $action->execute($id, $request->user()->id, $validated['approved']);

        return back()->with('success', $expense->statut === 'approuve' ? 'Note de frais approuvée.' : 'Note de frais rejetée.');
    }

    public function destroy(Request $request, int $id)
    {
        $tenantId = $request->user()->tenant_id;
        $expense = Expense::whereHas('employee', fn ($q) => $q->where('tenant_id', $tenantId))->findOrFail($id);

        if ($expense->statut !== 'en_attente') {
            return back()->withErrors(['error' => 'Seules les notes de frais en attente peuvent être supprimées.']);
        }

        $expense->delete();

        return redirect()->route('paie.expenses.index')
            ->with('success', 'Note de frais supprimée.');
    }
}
