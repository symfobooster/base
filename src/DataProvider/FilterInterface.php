<?php

namespace Zabachok\Symfobooster\DataProvider;

use Doctrine\ORM\QueryBuilder;
use Zabachok\Symfobooster\Input\InputInterface;

interface FilterInterface
{
    public function setQuery(QueryBuilder $query): void;
    public function isApplicable(): bool;
    public function setInput(InputInterface $input): void;
}