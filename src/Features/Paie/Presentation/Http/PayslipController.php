<?php

namespace Src\Features\Paie\Presentation\Http;

use App\Http\Controllers\Controller;
use App\Models\Paie\Employee;
use App\Models\Paie\Payslip;
use Illuminate\Http\Request;
use Src\Features\Paie\Application\DTOs\GeneratePayslipDTO;
use Src\Features\Paie\Application\Actions\Payslip\GeneratePayslipAction;
use Src\Features\Paie\Application\Actions\Payslip\SimulatePayslipAction;
use Src\Features\Paie\Application\Actions\Payslip\ValidatePayslipAction;
use Src\Features\Paie\Infrastructure\Persistence\EloquentPayslipRepository;

class PayslipController extends Controller
{
    public function index(Request $request)
    {
        $tenantId = (int) $request->user()->tenant_id;

        $repository = new EloquentPayslipRepository();
        $payslips = $repository->paginated($tenantId, $request->only(['mois', 'annee', 'statut', 'employee_id']), 15);

        return view('paie.payslips.index', compact('payslips'));
    }

    public function create(Request $request)
    {
        $tenantId = (int) $request->user()->tenant_id;
        $employees = Employee::where('tenant_id', $tenantId)->where('statut', 'actif')->orderBy('nom')->get();

        return view('paie.payslips.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|integer|exists:paie_employees,id',
            'mois' => 'required|integer|min:1|max:12',
            'annee' => 'required|integer|min:2020|max:2030',
            'heures_sup_jour' => 'nullable|integer|min:0|max:240',
            'heures_sup_nuit' => 'nullable|integer|min:0|max:120',
            'prime_anciennete' => 'nullable|integer|min:0',
            'prime_rendement' => 'nullable|integer|min:0',
            'prime_risque' => 'nullable|integer|min:0',
            'prime_13eme' => 'nullable|integer|min:0',
            'indemnite_transport' => 'nullable|integer|min:0',
            'indemnite_logement' => 'nullable|integer|min:0',
            'indemnite_responsabilite' => 'nullable|integer|min:0',
            'avantages_nature' => 'nullable|integer|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);

        $dto = GeneratePayslipDTO::fromarray(array_merge($validated, ['tenant_id' => (int) $request->user()->tenant_id]));

        $action = new GeneratePayslipAction(new EloquentPayslipRepository());
        $payslip = $action->execute($dto);

        return redirect()->route('paie.payslips.show', $payslip->id)
            ->with('success', 'Bulletin généré avec succès.');
    }

    public function show(Request $request, int $id)
    {
        $tenantId = (int) $request->user()->tenant_id;
        $payslip = Payslip::where('tenant_id', $tenantId)->with('employee')->findOrFail($id);

        return view('paie.payslips.show', compact('payslip'));
    }

    public function validate(Request $request, int $id)
    {
        $tenantId = (int) $request->user()->tenant_id;

        $action = new ValidatePayslipAction(new EloquentPayslipRepository());
        $payslip = $action->execute($id, $tenantId, $request->user()->id);

        return redirect()->route('paie.payslips.show', $payslip->id)
            ->with('success', 'Bulletin validé avec succès.');
    }

    public function simulate(Request $request)
    {
        $validated = $request->validate([
            'salaire_base' => 'required|integer|min:1',
            'nb_enfants' => 'nullable|integer|min:0|max:20',
            'situation_familiale' => 'nullable|in:celibataire,marie,divorce,veuf',
            'heures_sup_jour' => 'nullable|integer|min:0',
            'heures_sup_nuit' => 'nullable|integer|min:0',
            'prime_anciennete' => 'nullable|integer|min:0',
            'prime_rendement' => 'nullable|integer|min:0',
            'prime_risque' => 'nullable|integer|min:0',
            'prime_13eme' => 'nullable|integer|min:0',
            'indemnite_transport' => 'nullable|integer|min:0',
            'indemnite_logement' => 'nullable|integer|min:0',
            'indemnite_responsabilite' => 'nullable|integer|min:0',
            'avantages_nature' => 'nullable|integer|min:0',
        ]);

        $action = new SimulatePayslipAction(new EloquentPayslipRepository());
        $result = $action->execute($validated);

        return response()->json($result);
    }

    public function destroy(Request $request, int $id)
    {
        $tenantId = (int) $request->user()->tenant_id;
        $payslip = Payslip::where('tenant_id', $tenantId)->findOrFail($id);

        if ($payslip->statut !== 'brouillon') {
            return back()->withErrors(['error' => 'Seuls les bulletins en brouillon peuvent être supprimés.']);
        }

        $payslip->delete();

        return redirect()->route('paie.payslips.index')
            ->with('success', 'Bulletin supprimé.');
    }
}
