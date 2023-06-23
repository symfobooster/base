<?php

namespace Symfobooster\Base\DataProvider;

use Symfobooster\Base\Input\InputInterface;

abstract class AbstractFilter implements FilterInterface
{
    protected InputInterface $input;

    public function setInput(InputInterface $input): void
    {
        $this->input = $input;
    }

    public function isApplicable(): bool
    {
        return true;
    }
}
