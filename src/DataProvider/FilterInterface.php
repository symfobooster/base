<?php

namespace Symfobooster\Base\DataProvider;

use Symfobooster\Base\Input\InputInterface;

interface FilterInterface
{
    public function setQuery(mixed $query): void;

    public function isApplicable(): bool;

    public function setInput(InputInterface $input): void;
}
