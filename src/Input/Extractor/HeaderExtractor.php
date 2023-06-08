<?php

namespace Zabachok\Symfobooster\Input\Extractor;

use Symfony\Component\HttpFoundation\Request;

class HeaderExtractor implements ExtractorInterface
{
    public function extract(Request $request, string $name): mixed
    {
        return $request->headers->get($name);
    }
}
