<?php

namespace Symfobooster\Base\DataProvider;


use Symfobooster\Base\Input\InputInterface;

interface DataProviderInterface
{
    public function getRecords(): array;

    public function getTotal(): int;

    public function setInput(InputInterface $input): void;
}
 