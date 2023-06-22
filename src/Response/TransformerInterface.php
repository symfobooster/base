<?php

namespace Symfobooster\Base\Response;

use Symfony\Component\HttpFoundation\Response;

interface TransformerInterface
{
    public function transform(mixed $output): Response;
}
