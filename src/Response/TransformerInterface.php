<?php

namespace Symfobooster\Base\Response;

use Symfony\Component\HttpFoundation\Response;
use Symfobooster\Base\Output\OutputInterface;

interface TransformerInterface
{
    public function transform(OutputInterface $output): Response;
}
