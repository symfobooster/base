<?php

namespace Symfobooster\Base\DataProvider;

interface FilterRepositoryInterface
{
    /**
     * @param FilterInterface[] $filters
     */
    public function getRecordsByFilters(array $filters): array;

    /**
     * @param FilterInterface[] $filters
     */
    public function getTotalByFilters(array $filters): int;
}
