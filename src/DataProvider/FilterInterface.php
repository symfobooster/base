<?php

namespace Symfobooster\Base\DataProvider;

use Doctrine\ORM\QueryBuilder;
use Symfobooster\Base\Input\InputInterface;

interface FilterInterface
{
    public function setQuery(QueryBuilder $query): void;

    public function isApplicable(): bool;

    public function setInput(InputInterface $input): void;
}
