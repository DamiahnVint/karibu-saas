<?php

namespace Src\Features\Cms\Application\Actions;

use Src\Features\Cms\Domain\Contracts\PageRepositoryInterface;
use Src\Features\Cms\Domain\ValueObjects\PageData;

class CreatePageAction
{
    public function __construct(
        protected PageRepositoryInterface $pages,
    ) {}

    public function execute(array $data): PageData
    {
        return $this->pages->save(PageData::fromArray($data));
    }
}
