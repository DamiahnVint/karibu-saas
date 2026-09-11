<?php

namespace Src\Features\Paie\Presentation\Http;

use App\Http\Controllers\Controller;
use App\Models\Paie\Employee;
use App\Models\Paie\Department;
use Illuminate\Http\Request;
use Src\Features\Paie\Application\DTOs\StoreEmployeeDTO;
use Src\Features\Paie\Application\Actions\Employee\StoreEmployeeAction;
use Src\Features\Paie\Application\Actions\Employee\UpdateEmployeeAction;
use Src\Features\Paie\Infrastructure\Persistence\EloquentEmployeeRepository;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $tenantId = $request->user()->tenant_id;

        $repository = new EloquentEmployeeRepository();
        $employees = $repository->paginated($tenantId, $request->only(['search', 'statut', 'department_id']), 15);
        $departments = Department::where('tenant_id', $tenantId)->orderBy('name')->get();

        return view('paie.employees.index', compact('employees', 'departments'));
    }

    public function create(Request $request)
    {
        $tenantId = $request->user()->tenant_id;
        $departments = Department::where('tenant_id', $tenantId)->orderBy('name')->get();

        return view('paie.employees.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'date_naissance' => 'nullable|date|before:today',
            'sexe' => 'nullable|in:M,F',
            'situation_familiale' => 'required|in:celibataire,marie,divorce,veuf',
            'nb_enfants' => 'nullable|integer|min:0|max:20',
            'poste' => 'nullable|string|max:255',
            'department_id' => 'nullable|integer|exists:paie_departments,id',
            'date_embauche' => 'required|date|before_or_equal:today',
            'type_contrat' => 'required|in:cdi,cdd,saisonnier,stage',
            'duree_contrat' => 'nullable|required_if:type_contrat,cdd|date|after:date_embauche',
            'salaire_base' => 'required|integer|min:1',
            'mode_paiement' => 'required|in:virement,cheque,especes,mobile_money',
            'banque' => 'nullable|string|max:255',
            'rib' => 'nullable|string|max:30',
            'cnps_numero' => 'nullable|string|max:20',
            'statut' => 'required|in:actif,inactif,suspendu,radie',
            'notes' => 'nullable|string|max:1000',
        ]);

        $dto = StoreEmployeeDTO::fromarray(array_merge($validated, ['tenant_id' => $request->user()->tenant_id]));

        $action = new StoreEmployeeAction(new EloquentEmployeeRepository());
        $employee = $action->execute($dto);

        return redirect()->route('paie.employees.show', $employee->id)
            ->with('success', 'Employé créé avec succès.');
    }

    public function show(Request $request, int $id)
    {
        $tenantId = $request->user()->tenant_id;
        $employee = Employee::where('tenant_id', $tenantId)->findOrFail($id);

        $employee->load(['department', 'contracts', 'payslips' => function ($q) {
            $q->orderByDesc('annee')->orderByDesc('mois')->limit(12);
        }, 'leaves' => function ($q) {
            $q->orderByDesc('date_debut')->limit(10);
        }]);

        $departments = Department::where('tenant_id', $tenantId)->orderBy('name')->get();

        return view('paie.employees.show', compact('employee', 'departments'));
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'date_naissance' => 'nullable|date|before:today',
            'sexe' => 'nullable|in:M,F',
            'situation_familiale' => 'required|in:celibataire,marie,divorce,veuf',
            'nb_enfants' => 'nullable|integer|min:0|max:20',
            'poste' => 'nullable|string|max:255',
            'department_id' => 'nullable|integer|exists:paie_departments,id',
            'date_embauche' => 'required|date',
            'type_contrat' => 'required|in:cdi,cdd,saisonnier,stage',
            'duree_contrat' => 'nullable|date',
            'salaire_base' => 'required|integer|min:1',
            'mode_paiement' => 'required|in:virement,cheque,especes,mobile_money',
            'banque' => 'nullable|string|max:255',
            'rib' => 'nullable|string|max:30',
            'cnps_numero' => 'nullable|string|max:20',
            'statut' => 'required|in:actif,inactif,suspendu,radie',
            'notes' => 'nullable|string|max:1000',
        ]);

        $dto = StoreEmployeeDTO::fromarray(array_merge($validated, ['tenant_id' => $request->user()->tenant_id]));

        $action = new UpdateEmployeeAction(new EloquentEmployeeRepository());
        $employee = $action->execute($id, $request->user()->tenant_id, $dto);

        return redirect()->route('paie.employees.show', $employee->id)
            ->with('success', 'Employé mis à jour avec succès.');
    }

    public function destroy(Request $request, int $id)
    {
        $tenantId = $request->user()->tenant_id;
        $employee = Employee::where('tenant_id', $tenantId)->findOrFail($id);
        $employee->delete();

        return redirect()->route('paie.employees.index')
            ->with('success', 'Employé supprimé.');
    }
}
