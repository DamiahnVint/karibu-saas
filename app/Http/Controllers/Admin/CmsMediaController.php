<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CmsMediaController extends Controller
{
    public function index()
    {
        $media = CmsMedia::latest()->paginate(24);

        return view('admin.cms.media.index', compact('media'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|file|max:5120|mimes:jpg,jpeg,png,gif,svg,webp,pdf',
            'alt_text' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:100',
        ]);

        $file = $request->file('file');
        $name = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('cms', $name, 'public');

        CmsMedia::create([
            'name' => $name,
            'file_path' => $path,
            'file_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'alt_text' => $validated['alt_text'] ?? null,
            'category' => $validated['category'] ?? 'general',
        ]);

        return redirect()->route('admin.cms.media.index')->with('success', 'Média uploadé.');
    }

    public function destroy(CmsMedia $media)
    {
        $fullPath = storage_path('app/public/' . $media->file_path);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }

        $media->delete();

        return redirect()->route('admin.cms.media.index')->with('success', 'Média supprimé.');
    }
}
