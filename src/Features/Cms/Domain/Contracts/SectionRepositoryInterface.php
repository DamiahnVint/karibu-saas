<?php

namespace Src\Features\Cms\Domain\Contracts;

use Src\Features\Cms\Domain\ValueObjects\SectionData;

interface SectionRepositoryInterface
{
    public function findById(int $id): ?SectionData;

    public function findByPageId(int $pageId): array;

    public function findActiveByPageId(int $pageId): array;

    public function save(SectionData $section): SectionData;

    public function delete(int $id): bool;
}
