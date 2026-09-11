<?php

namespace Src\Features\Paie\Presentation\Http;

use App\Http\Controllers\Controller;
use App\Models\Paie\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $tenantId = $request->user()->tenant_id;
        $departments = Department::where('tenant_id', $tenantId)->with('employees')->orderBy('name')->get();

        return view('paie.departments.index', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'parent_id' => 'nullable|integer|exists:paie_departments,id',
        ]);

        $department = new Department();
        $department->tenant_id = $request->user()->tenant_id;
        $department->name = $validated['name'];
        $department->description = $validated['description'] ?? null;
        $department->parent_id = $validated['parent_id'] ?? null;
        $department->save();

        return redirect()->route('paie.departments.index')
            ->with('success', 'Département créé avec succès.');
    }

    public function update(Request $request, int $id)
    {
        $tenantId = $request->user()->tenant_id;
        $department = Department::where('tenant_id', $tenantId)->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $department->name = $validated['name'];
        $department->description = $validated['description'] ?? null;
        $department->save();

        return redirect()->route('paie.departments.index')
            ->with('success', 'Département mis à jour.');
    }

    public function destroy(Request $request, int $id)
    {
        $tenantId = $request->user()->tenant_id;
        $department = Department::where('tenant_id', $tenantId)->findOrFail($id);

        if ($department->employees()->count() > 0) {
            return back()->withErrors(['error' => 'Ce contient des employés et ne peut être supprimé.']);
        }

        $department->delete();

        return redirect()->route('paie.departments.index')
            ->with('success', 'Département supprimé.');
    }
}
