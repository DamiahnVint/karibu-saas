<?php

namespace Src\Features\Cms\Application\Actions;

use Src\Features\Cms\Domain\Contracts\SectionRepositoryInterface;
use Src\Features\Cms\Domain\ValueObjects\SectionData;

class UpdateSectionAction
{
    public function __construct(
        protected SectionRepositoryInterface $sections,
    ) {}

    public function execute(int $id, array $data): SectionData
    {
        $data['id'] = $id;
        return $this->sections->save(SectionData::fromArray($data));
    }
}
