<?php

namespace Src\Features\Cms\Domain\Contracts;

use Src\Features\Cms\Domain\ValueObjects\PageData;

interface PageRepositoryInterface
{
    public function findBySlug(string $slug): ?PageData;

    public function findById(int $id): ?PageData;

    public function findActivePages(): array;

    public function save(PageData $page): PageData;

    public function delete(int $id): bool;
}
