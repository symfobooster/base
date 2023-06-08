<?php

namespace Zabachok\Symfobooster\DataProvider;

interface FilterRepositoryInterface
{
    public function getRecordsByFilters(array $filters): array;
    public function getTotalByFilters(array $filters): int;
}