<?php

declare(strict_types=1);

namespace Symfobooster\Base\DataProvider;

use Symfobooster\Base\Input\InputInterface;

class FilterEnum implements FilterEnumInterface
{
    private array $validForRecords = [];
    private array $validForTotal = [];

    /**
     * @param FilterInterface[] $filtersForRecords
     * @param FilterInterface[] $filtersForTotal
     */
    public function __construct(
        private readonly array $filtersForRecords = [],
        private readonly array $filtersForTotal = [],
    )
    {
    }

    public function getFiltersForRecords(): array
    {
        return $this->validForRecords;
    }

    public function getFiltersForTotal(): array
    {
        return $this->validForTotal;
    }

    public function setInput(InputInterface $input): void
    {
        $this->validForRecords = $this->loadFilters($input, $this->filtersForRecords);
        $this->validForTotal = $this->loadFilters($input, $this->filtersForTotal);
    }

    private function loadFilters(InputInterface $input, array $filters): array
    {
        $result = [];
        foreach ($filters as $filter) {
            $filter->setInput($input);
            if ($filter->isApplicable()) {
                $result[] = $filter;
            }
        }

        return $result;
    }
}
