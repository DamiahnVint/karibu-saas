<?php

namespace Src\Features\Cms\Domain\ValueObjects;

readonly class PageData
{
    public function __construct(
        public ?int $id,
        public string $slug,
        public string $title,
        public ?string $metaTitle,
        public ?string $metaDescription,
        public string $template,
        public bool $isActive,
        public int $sortOrder,
        public ?array $sections = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            slug: $data['slug'],
            title: $data['title'],
            metaTitle: $data['meta_title'] ?? null,
            metaDescription: $data['meta_description'] ?? null,
            template: $data['template'] ?? 'default',
            isActive: $data['is_active'] ?? true,
            sortOrder: $data['sort_order'] ?? 0,
            sections: $data['sections'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'meta_title' => $this->metaTitle,
            'meta_description' => $this->metaDescription,
            'template' => $this->template,
            'is_active' => $this->isActive,
            'sort_order' => $this->sortOrder,
            'sections' => $this->sections,
        ];
    }
}
