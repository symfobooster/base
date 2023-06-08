<?php

namespace Zabachok\Symfobooster\Service;

use Zabachok\Symfobooster\Input\InputInterface;
use Zabachok\Symfobooster\Output\OutputInterface;

interface ServiceInterface
{
    public function behave(InputInterface $input): OutputInterface;
}
