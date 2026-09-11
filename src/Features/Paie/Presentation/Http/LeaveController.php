<?php

namespace Src\Features\Paie\Presentation\Http;

use App\Http\Controllers\Controller;
use App\Models\Paie\Employee;
use App\Models\Paie\Leave;
use Illuminate\Http\Request;
use Src\Features\Paie\Application\DTOs\StoreLeaveDTO;
use Src\Features\Paie\Application\Actions\Leave\StoreLeaveAction;
use Src\Features\Paie\Application\Actions\Leave\ApproveLeaveAction;
use Src\Features\Paie\Infrastructure\Persistence\EloquentLeaveRepository;

class LeaveController extends Controller
{
    public function index(Request $request)
    {
        $tenantId = $request->user()->tenant_id;

        $repository = new EloquentLeaveRepository();
        $leaves = $repository->paginated($tenantId, $request->only(['statut', 'type', 'employee_id']), 15);

        return view('paie.leaves.index', compact('leaves'));
    }

    public function create(Request $request)
    {
        $tenantId = $request->user()->tenant_id;
        $employees = Employee::where('tenant_id', $tenantId)->where('statut', 'actif')->orderBy('nom')->get();

        return view('paie.leaves.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|integer|exists:paie_employees,id',
            'type' => 'required|in:paye,maladie,maternite,paternite,sans_solde,deces,mariage,naissance',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'nb_jours' => 'required|integer|min:1|max:365',
            'motif' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:500',
        ]);

        $dto = StoreLeaveDTO::fromarray(array_merge($validated, ['tenant_id' => $request->user()->tenant_id]));

        $action = new StoreLeaveAction(new EloquentLeaveRepository());
        $leave = $action->execute($dto);

        return redirect()->route('paie.leaves.index')
            ->with('success', 'Demande de congé soumise avec succès.');
    }

    public function approve(Request $request, int $id)
    {
        $validated = $request->validate([
            'approved' => 'required|boolean',
        ]);

        $action = new ApproveLeaveAction(new EloquentLeaveRepository());
        $leave = $action->execute($id, $request->user()->id, $validated['approved']);

        return back()->with('success', $leave->statut === 'approuve' ? 'Congé approuvé.' : 'Congé rejeté.');
    }

    public function destroy(Request $request, int $id)
    {
        $tenantId = $request->user()->tenant_id;
        $leave = Leave::whereHas('employee', fn ($q) => $q->where('tenant_id', $tenantId))->findOrFail($id);

        if ($leave->statut !== 'en_attente') {
            return back()->withErrors(['error' => 'Seules les demandes en attente peuvent être supprimées.']);
        }

        $leave->delete();

        return redirect()->route('paie.leaves.index')
            ->with('success', 'Demande de congé supprimée.');
    }
}
