<?php

namespace Src\Features\Cms\Infrastructure\Persistence;

use App\Models\CmsSection;
use Src\Features\Cms\Domain\Contracts\SectionRepositoryInterface;
use Src\Features\Cms\Domain\ValueObjects\SectionData;

class EloquentSectionRepository implements SectionRepositoryInterface
{
    public function __construct(
        protected CmsSection $model,
    ) {}

    public function findById(int $id): ?SectionData
    {
        $section = $this->model->find($id);

        if (!$section) {
            return null;
        }

        return SectionData::fromArray($section->toArray());
    }

    public function findByPageId(int $pageId): array
    {
        return $this->model
            ->where('page_id', $pageId)
            ->orderBy('sort_order')
            ->get()
            ->map(fn ($s) => SectionData::fromArray($s->toArray()))
            ->toArray();
    }

    public function findActiveByPageId(int $pageId): array
    {
        return $this->model
            ->where('page_id', $pageId)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(fn ($s) => SectionData::fromArray($s->toArray()))
            ->toArray();
    }

    public function save(SectionData $section): SectionData
    {
        $attributes = $section->toArray();
        unset($attributes['id']);

        $model = $this->model->updateOrCreate(
            ['id' => $section->id],
            $attributes
        );

        return SectionData::fromArray($model->toArray());
    }

    public function delete(int $id): bool
    {
        return $this->model->find($id)?->delete() ?? false;
    }
}
