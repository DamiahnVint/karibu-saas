<?php

namespace App\Http\Controllers;

use App\Models\CmsPage;
use App\Models\CmsSetting;
use App\Models\CmsNavigation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\QueryException;

class CmsPageController extends Controller
{
    /**
     * Rend une page CMS publique depuis la base de données.
     * Fallback vers la vue Blade statique si les tables CMS n'existent pas.
     */
    public function render(string $slug)
    {
        try {
            $page = Cache::remember("cms_page_{$slug}", 300, function () use ($slug) {
                $model = CmsPage::with(['activeSections' => fn ($q) => $q->orderBy('sort_order')])
                    ->where('slug', $slug)
                    ->where('is_active', true)
                    ->first();

                if (!$model) {
                    return null;
                }

                return [
                    'page' => [
                        'id' => $model->id,
                        'slug' => $model->slug,
                        'title' => $model->title,
                        'meta_title' => $model->meta_title,
                        'meta_description' => $model->meta_description,
                        'template' => $model->template,
                        'sections' => $model->activeSections->map(fn ($s) => [
                            'id' => $s->id,
                            'type' => $s->type,
                            'title' => $s->title,
                            'content' => $s->content,
                            'sort_order' => $s->sort_order,
                        ])->toArray(),
                    ],
                    'settings' => $this->getSettings(),
                    'navigation' => $this->getNavigation(),
                ];
            });

            if (!$page) {
                abort(404);
            }

            $pageData = $page['page'];
            $settings = $page['settings'];
            $navigation = $page['navigation'];

            return view('cms.render', compact('pageData', 'settings', 'navigation'));
        } catch (QueryException $e) {
            if (str_contains($e->getMessage(), 'no such table')) {
                return $this->fallbackView($slug);
            }
            throw $e;
        }
    }

    /**
     * Page d'accueil — alias vers la landing.
     */
    public function home()
    {
        return $this->render('landing');
    }

    /**
     * Fallback : rend la vue Blade statique correspondante.
     */
    protected function fallbackView(string $slug)
    {
        $views = [
            'landing' => 'landing',
            'pricing' => 'pricing.index',
            'demo' => 'demo.index',
            'contact' => 'demo.index',
        ];

        $view = $views[$slug] ?? null;

        if (!$view || !view()->exists($view)) {
            abort(404);
        }

        return view($view);
    }

    protected function getSettings(): array
    {
        return Cache::remember('cms_settings_all', 1800, function () {
            return CmsSetting::all()->pluck('value', 'key')->toArray();
        });
    }

    protected function getNavigation(): array
    {
        return [
            'header' => CmsNavigation::getItems('header'),
            'footer' => CmsNavigation::getItems('footer'),
            'mobile' => CmsNavigation::getItems('mobile'),
        ];
    }
}
