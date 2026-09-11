<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use App\Models\CmsFormSubmission;
use App\Models\Plan;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $tenant = $user->tenant;
        $isSuperAdmin = $user->role === 'super_admin';

        $stats = [];

        if ($isSuperAdmin) {
            $stats = [
                'tenants_total' => Tenant::count(),
                'tenants_active' => Tenant::where('is_active', true)->count(),
                'plans_total' => Plan::count(),
                'pages_total' => CmsPage::count(),
                'pages_active' => CmsPage::where('is_active', true)->count(),
                'forms_unread' => CmsFormSubmission::where('is_read', false)->count(),
            ];
        }

        return view('tenant.dashboard', [
            'userName' => $user->name,
            'userRole' => $user->role,
            'tenantName' => $tenant?->name ?? 'Administration',
            'isSuperAdmin' => $isSuperAdmin,
            'stats' => $stats,
        ]);
    }
}
