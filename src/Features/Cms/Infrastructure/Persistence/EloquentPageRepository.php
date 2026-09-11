<?php

namespace Src\Features\Cms\Infrastructure\Persistence;

use App\Models\CmsPage;
use Src\Features\Cms\Domain\Contracts\PageRepositoryInterface;
use Src\Features\Cms\Domain\ValueObjects\PageData;

class EloquentPageRepository implements PageRepositoryInterface
{
    public function __construct(
        protected CmsPage $model,
    ) {}

    public function findBySlug(string $slug): ?PageData
    {
        $page = $this->model
            ->with(['activeSections' => fn ($q) => $q->orderBy('sort_order')])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->first();

        if (!$page) {
            return null;
        }

        return PageData::fromArray(
            $page->toArray() + ['sections' => $page->activeSections->toArray()]
        );
    }

    public function findById(int $id): ?PageData
    {
        $page = $this->model->with('sections')->find($id);

        if (!$page) {
            return null;
        }

        return PageData::fromArray(
            $page->toArray() + ['sections' => $page->sections->toArray()]
        );
    }

    public function findActivePages(): array
    {
        return $this->model
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(fn ($page) => PageData::fromArray($page->toArray()))
            ->toArray();
    }

    public function save(PageData $page): PageData
    {
        $attributes = $page->toArray();
        unset($attributes['id'], $attributes['sections']);

        $model = $this->model->updateOrCreate(
            ['id' => $page->id],
            $attributes
        );

        return PageData::fromArray($model->toArray());
    }

    public function delete(int $id): bool
    {
        return $this->model->find($id)?->delete() ?? false;
    }
}
