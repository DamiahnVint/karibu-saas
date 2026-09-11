<?php

namespace Src\Features\Cms\Infrastructure\Persistence;

use App\Models\CmsFormSubmission;
use Src\Features\Cms\Domain\Contracts\FormSubmissionRepositoryInterface;

class EloquentFormSubmissionRepository implements FormSubmissionRepositoryInterface
{
    public function __construct(
        protected CmsFormSubmission $model,
    ) {}

    public function store(string $type, array $data, ?string $ip): void
    {
        $this->model->create([
            'form_type' => $type,
            'data' => $data,
            'ip_address' => $ip,
        ]);
    }

    public function find(int $id): ?array
    {
        return $this->model->find($id)?->toArray();
    }

    public function findByType(string $type, bool $unreadOnly = false): array
    {
        $query = $this->model->where('form_type', $type);

        if ($unreadOnly) {
            $query->where('is_read', false);
        }

        return $query->latest()->get()->toArray();
    }

    public function markAsRead(int $id): void
    {
        $this->model->find($id)?->markAsRead();
    }

    public function delete(int $id): bool
    {
        return $this->model->find($id)?->delete() ?? false;
    }

    public function countUnread(string $type): int
    {
        return $this->model->where('form_type', $type)->where('is_read', false)->count();
    }
}
