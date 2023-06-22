<?php

namespace Symfobooster\Base\Service;

use Symfobooster\Base\Input\InputInterface;

interface ServiceInterface
{
    public function behave(InputInterface $input): mixed;
}
