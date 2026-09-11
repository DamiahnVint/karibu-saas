<?php

namespace Src\Features\Paie\Presentation\Http;

use App\Http\Controllers\Controller;
use App\Models\Paie\Employee;
use App\Models\Paie\Payslip;
use App\Models\Paie\Leave;
use App\Models\Paie\Department;
use Illuminate\Http\Request;

class PaieDashboardController extends Controller
{
    public function index(Request $request)
    {
        $tenantId = $request->user()->tenant_id;

        $totalEmployees = Employee::where('tenant_id', $tenantId)->count();
        $activeEmployees = Employee::where('tenant_id', $tenantId)->where('statut', 'actif')->count();

        $currentMonth = (int) now()->month;
        $currentYear = (int) now()->year;

        $payslipsThisMonth = Payslip::where('tenant_id', $tenantId)
            ->where('mois', $currentMonth)
            ->where('annee', $currentYear)
            ->count();

        $totalNetThisMonth = Payslip::where('tenant_id', $tenantId)
            ->where('mois', $currentMonth)
            ->where('annee', $currentYear)
            ->where('statut', '!=', 'brouillon')
            ->sum('net_a_payer');

        $totalCnpsEmployer = Payslip::where('tenant_id', $tenantId)
            ->where('mois', $currentMonth)
            ->where('annee', $currentYear)
            ->where('statut', '!=', 'brouillon')
            ->sum('total_cnps_employeur');

        $pendingLeaves = Leave::whereHas('employee', fn ($q) => $q->where('tenant_id', $tenantId))
            ->where('statut', 'en_attente')
            ->count();

        $pendingExpenses = \App\Models\Paie\Expense::whereHas('employee', fn ($q) => $q->where('tenant_id', $tenantId))
            ->where('statut', 'en_attente')
            ->count();

        $recentPayslips = Payslip::where('tenant_id', $tenantId)
            ->with('employee')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('paie.dashboard', compact(
            'totalEmployees',
            'activeEmployees',
            'payslipsThisMonth',
            'totalNetThisMonth',
            'totalCnpsEmployer',
            'pendingLeaves',
            'pendingExpenses',
            'recentPayslips',
            'currentMonth',
            'currentYear',
        ));
    }
}
