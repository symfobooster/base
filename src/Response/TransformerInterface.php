<?php

namespace Zabachok\Symfobooster\Response;

use Symfony\Component\HttpFoundation\Response;
use Zabachok\Symfobooster\Output\OutputInterface;

interface TransformerInterface
{
    public function transform(OutputInterface $output): Response;
}
