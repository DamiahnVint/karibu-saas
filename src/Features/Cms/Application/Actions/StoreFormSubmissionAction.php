<?php

namespace Src\Features\Cms\Application\Actions;

use Src\Features\Cms\Domain\Contracts\FormSubmissionRepositoryInterface;

class StoreFormSubmissionAction
{
    public function __construct(
        protected FormSubmissionRepositoryInterface $submissions,
    ) {}

    public function execute(string $type, array $data, ?string $ip = null): void
    {
        $this->submissions->store($type, $data, $ip);
    }
}
