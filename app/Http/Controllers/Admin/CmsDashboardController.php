<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use App\Models\CmsSection;
use App\Models\CmsSetting;
use App\Models\CmsNavigation;
use App\Models\CmsMedia;
use App\Models\CmsFormSubmission;

class CmsDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'pages' => CmsPage::count(),
            'pages_active' => CmsPage::where('is_active', true)->count(),
            'sections' => CmsSection::count(),
            'media' => CmsMedia::count(),
            'forms_unread' => CmsFormSubmission::where('is_read', false)->count(),
            'settings' => CmsSetting::count(),
        ];

        $recentSubmissions = CmsFormSubmission::latest()->limit(5)->get();
        $recentPages = CmsPage::latest()->limit(5)->get();

        return view('admin.cms.dashboard', compact('stats', 'recentSubmissions', 'recentPages'));
    }
}
