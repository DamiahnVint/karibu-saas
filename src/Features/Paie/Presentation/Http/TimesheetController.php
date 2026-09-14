<?php

namespace Src\Features\Paie\Presentation\Http;

use App\Http\Controllers\Controller;
use App\Models\Paie\Employee;
use App\Models\Paie\Timesheet;
use Illuminate\Http\Request;
use Src\Features\Paie\Application\DTOs\StoreTimesheetDTO;
use Src\Features\Paie\Application\Actions\Timesheet\StoreTimesheetAction;
use Src\Features\Paie\Infrastructure\Persistence\EloquentTimesheetRepository;

class TimesheetController extends Controller
{
    public function index(Request $request)
    {
        $tenantId = (int) $request->user()->tenant_id;

        $repository = new EloquentTimesheetRepository();
        $timesheets = $repository->paginated($tenantId, $request->only(['employee_id', 'date_from', 'date_to']), 15);

        return view('paie.timesheets.index', compact('timesheets'));
    }

    public function create(Request $request)
    {
        $tenantId = (int) $request->user()->tenant_id;
        $employees = Employee::where('tenant_id', $tenantId)->where('statut', 'actif')->orderBy('nom')->get();

        return view('paie.timesheets.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|integer|exists:paie_employees,id',
            'date' => 'required|date|before_or_equal:today',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i',
            'pause' => 'nullable|integer|min:0|max:480',
            'notes' => 'nullable|string|max:500',
        ]);

        $dto = StoreTimesheetDTO::fromarray(array_merge($validated, ['tenant_id' => (int) $request->user()->tenant_id]));

        $action = new StoreTimesheetAction(new EloquentTimesheetRepository());
        $timesheet = $action->execute($dto);

        return redirect()->route('paie.timesheets.index')
            ->with('success', 'Feuille de temps enregistrée.');
    }

    public function destroy(Request $request, int $id)
    {
        $tenantId = (int) $request->user()->tenant_id;
        $timesheet = Timesheet::whereHas('employee', fn ($q) => $q->where('tenant_id', $tenantId))->findOrFail($id);

        if ($timesheet->statut === 'valide') {
            return back()->withErrors(['error' => 'Les feuilles de temps validées ne peuvent être supprimées.']);
        }

        $timesheet->delete();

        return redirect()->route('paie.timesheets.index')
            ->with('success', 'Feuille de temps supprimée.');
    }
}
