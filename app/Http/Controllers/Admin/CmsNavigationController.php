<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsNavigation;
use Illuminate\Http\Request;

class CmsNavigationController extends Controller
{
    public function index()
    {
        $navigations = [
            'header' => CmsNavigation::getItems('header'),
            'footer' => CmsNavigation::getItems('footer'),
            'mobile' => CmsNavigation::getItems('mobile'),
        ];

        return view('admin.cms.navigation', compact('navigations'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'location' => 'required|string|in:header,footer,mobile',
            'items' => 'required|array',
            'items.*.label' => 'required|string',
            'items.*.url' => 'required|string',
            'items.*.order' => 'nullable|integer',
        ]);

        $items = collect($validated['items'])
            ->map(fn ($item, $index) => [
                'label' => $item['label'],
                'url' => $item['url'],
                'order' => $item['order'] ?? $index,
            ])
            ->toArray();

        CmsNavigation::setItems($validated['location'], $items);

        return redirect()->route('admin.cms.navigation.index')->with('success', 'Navigation mise à jour.');
    }
}
