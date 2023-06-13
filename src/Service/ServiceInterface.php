<?php

namespace Symfobooster\Base\Service;

use Symfobooster\Base\Input\InputInterface;
use Symfobooster\Base\Output\OutputInterface;

interface ServiceInterface
{
    public function behave(InputInterface $input): OutputInterface;
}
