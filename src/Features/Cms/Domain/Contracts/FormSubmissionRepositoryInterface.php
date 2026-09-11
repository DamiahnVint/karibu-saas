<?php

namespace Src\Features\Cms\Domain\Contracts;

interface FormSubmissionRepositoryInterface
{
    public function store(string $type, array $data, ?string $ip): void;

    public function find(int $id): ?array;

    public function findByType(string $type, bool $unreadOnly = false): array;

    public function markAsRead(int $id): void;

    public function delete(int $id): bool;

    public function countUnread(string $type): int;
}
