<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsSetting;
use Illuminate\Http\Request;

class CmsSettingController extends Controller
{
    public function index()
    {
        $groups = CmsSetting::all()->groupBy('group');
        $groupsList = ['general', 'contact', 'social', 'seo', 'colors'];

        return view('admin.cms.settings', compact('groups', 'groupsList'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.*.key' => 'required|string',
            'settings.*.value' => 'nullable|string',
            'settings.*.group' => 'required|string',
        ]);

        foreach ($validated['settings'] as $item) {
            CmsSetting::setValue($item['key'], $item['value'], $item['group']);
        }

        CmsSetting::flushCache();

        return redirect()->route('admin.cms.settings.index')->with('success', 'Paramètres sauvegardés.');
    }
}
