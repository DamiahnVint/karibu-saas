<?php

namespace Src\Features\Cms\Domain\ValueObjects;

readonly class SectionData
{
    public function __construct(
        public ?int $id,
        public int $pageId,
        public string $type,
        public ?string $title,
        public array $content,
        public bool $isActive,
        public int $sortOrder,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            pageId: $data['page_id'],
            type: $data['type'],
            title: $data['title'] ?? null,
            content: $data['content'] ?? [],
            isActive: $data['is_active'] ?? true,
            sortOrder: $data['sort_order'] ?? 0,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'page_id' => $this->pageId,
            'type' => $this->type,
            'title' => $this->title,
            'content' => $this->content,
            'is_active' => $this->isActive,
            'sort_order' => $this->sortOrder,
        ];
    }
}
