<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use App\Models\CmsSection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CmsPageController extends Controller
{
    public function index()
    {
        $pages = CmsPage::withCount('sections')->orderBy('sort_order')->get();

        return view('admin.cms.pages.index', compact('pages'));
    }

    public function show(CmsPage $page)
    {
        $page->load(['sections' => fn ($q) => $q->orderBy('sort_order')]);

        return view('admin.cms.pages.show', compact('page'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:cms_pages,slug',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);

        CmsPage::create($validated);

        return redirect()->route('admin.cms.pages.index')->with('success', 'Page créée.');
    }

    public function update(Request $request, CmsPage $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'template' => 'nullable|string|max:100',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $page->update($validated);

        return redirect()->route('admin.cms.pages.show', $page)->with('success', 'Page mise à jour.');
    }

    public function destroy(CmsPage $page)
    {
        $page->delete();

        return redirect()->route('admin.cms.pages.index')->with('success', 'Page supprimée.');
    }

    public function storeSection(Request $request, CmsPage $page)
    {
        $validated = $request->validate([
            'type' => 'required|string|in:hero,features,pricing,testimonials,cta,text,contact,faq,gallery,html',
            'title' => 'nullable|string|max:255',
        ]);

        $validated['page_id'] = $page->id;
        $validated['content'] = $this->defaultContent($validated['type']);
        $validated['sort_order'] = $page->sections()->count();

        CmsSection::create($validated);

        return redirect()->route('admin.cms.pages.show', $page)->with('success', 'Section ajoutée.');
    }

    public function updateSection(Request $request, CmsPage $page, CmsSection $section)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'required|array',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $section->update($validated);

        return redirect()->route('admin.cms.pages.show', $page)->with('success', 'Section mise à jour.');
    }

    public function destroySection(CmsPage $page, CmsSection $section)
    {
        $section->delete();

        return redirect()->route('admin.cms.pages.show', $page)->with('success', 'Section supprimée.');
    }

    protected function defaultContent(string $type): array
    {
        return match ($type) {
            'hero' => ['title' => '', 'subtitle' => '', 'cta_text' => '', 'cta_url' => '#', 'background_image' => ''],
            'features' => ['items' => [['icon' => '', 'title' => '', 'description' => '']]],
            'pricing' => ['plans' => [['name' => '', 'price' => '', 'features' => [], 'is_popular' => false, 'cta_text' => 'Commencer']]],
            'testimonials' => ['items' => [['name' => '', 'company' => '', 'quote' => '', 'avatar' => '']]],
            'cta' => ['title' => '', 'description' => '', 'cta_text' => '', 'cta_url' => '#'],
            'text' => ['html_content' => ''],
            'contact' => ['fields' => [['name' => 'name', 'type' => 'text', 'required' => true], ['name' => 'email', 'type' => 'email', 'required' => true], ['name' => 'message', 'type' => 'textarea', 'required' => true]], 'submit_text' => 'Envoyer'],
            'faq' => ['items' => [['question' => '', 'answer' => '']]],
            'gallery' => ['items' => [['media_id' => null, 'caption' => '']]],
            'html' => ['html_content' => ''],
            default => [],
        };
    }
}
