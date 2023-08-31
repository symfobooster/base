<?php

declare(strict_types=1);

namespace Symfobooster\Base\DataProvider;

use Symfobooster\Base\Input\InputInterface;

interface FilterEnumInterface
{
    public function getFiltersForRecords(): array;

    public function getFiltersForTotal(): array;

    public function setInput(InputInterface $input): void;
}
