<?php

namespace Symfobooster\Base\Input\Extractor;

use Symfony\Component\HttpFoundation\Request;

interface ExtractorInterface
{
    public function extract(Request $request, string $name): mixed;
}
