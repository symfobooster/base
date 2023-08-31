<?php

declare(strict_types=1);

namespace Symfobooster\Base\DataProvider;

use Symfobooster\Base\Input\InputInterface;

class DataProvider implements DataProviderInterface
{
    public function __construct(private FilterRepositoryInterface $repository, private FilterEnumInterface $filterEnum)
    {
    }

    public function getRecords(): array
    {
        return $this->repository->getRecordsByFilters(
            $this->filterEnum->getFiltersForRecords()
        );
    }

    public function getTotal(): int
    {
        return $this->repository->getTotalByFilters(
            $this->filterEnum->getFiltersForTotal()
        );
    }

    public function setInput(InputInterface $input): void
    {
        $this->filterEnum->setInput($input);
    }
}
