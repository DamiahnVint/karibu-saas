<?php

namespace Src\Features\Paie\Presentation\Http;

use App\Http\Controllers\Controller;
use App\Models\Paie\Payslip;
use Illuminate\Http\Request;

class DeclarationController extends Controller
{
    public function index(Request $request)
    {
        $tenantId = (int) $request->user()->tenant_id;
        $mois = (int) ($request->get('mois', now()->month));
        $annee = (int) ($request->get('annee', now()->year));

        $payslips = Payslip::where('tenant_id', $tenantId)
            ->where('mois', $mois)
            ->where('annee', $annee)
            ->where('statut', '!=', 'brouillon')
            ->with('employee')
            ->get();

        $summary = [
            'total_employes' => $payslips->count(),
            'total_cnps_employeur' => $payslips->sum('total_cnps_employeur'),
            'total_cnps_salarie' => $payslips->sum('total_cnps_salarie'),
            'total_its_retenu' => $payslips->sum('its_net'),
            'total_net_a_payer' => $payslips->sum('net_a_payer'),
            'total_brut' => $payslips->sum('total_brut'),
        ];

        return view('paie.declarations.index', compact('payslips', 'summary', 'mois', 'annee'));
    }

    public function cnps(Request $request)
    {
        $tenantId = (int) $request->user()->tenant_id;
        $mois = (int) ($request->get('mois', now()->month));
        $annee = (int) ($request->get('annee', now()->year));

        $payslips = Payslip::where('tenant_id', $tenantId)
            ->where('mois', $mois)
            ->where('annee', $annee)
            ->where('statut', '!=', 'brouillon')
            ->with('employee')
            ->get();

        $synthese = [
            'retraite_employeur' => $payslips->sum('cnps_retraite_employeur'),
            'retraite_salarie' => $payslips->sum('cnps_retraite_salarie'),
            'maternite' => $payslips->sum('cnps_maternite'),
            'pf' => $payslips->sum('cnps_pf'),
            'at' => $payslips->sum('cnps_at'),
            'cmu_employeur' => $payslips->sum('cnps_cmu_employeur'),
            'cmu_salarie' => $payslips->sum('cnps_cmu_salarie'),
            'total' => $payslips->sum('total_cnps_employeur') + $payslips->sum('total_cnps_salarie'),
        ];

        return view('paie.declarations.cnps', compact('payslips', 'synthese', 'mois', 'annee'));
    }

    public function its(Request $request)
    {
        $tenantId = (int) $request->user()->tenant_id;
        $mois = (int) ($request->get('mois', now()->month));
        $annee = (int) ($request->get('annee', now()->year));

        $payslips = Payslip::where('tenant_id', $tenantId)
            ->where('mois', $mois)
            ->where('annee', $annee)
            ->where('statut', '!=', 'brouillon')
            ->with('employee')
            ->get();

        return view('paie.declarations.its', compact('payslips', 'mois', 'annee'));
    }
}
