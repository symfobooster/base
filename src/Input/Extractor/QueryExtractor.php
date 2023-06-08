<?php

namespace Zabachok\Symfobooster\Input\Extractor;

use Symfony\Component\HttpFoundation\Request;

class QueryExtractor implements ExtractorInterface
{
    public function extract(Request $request, string $name): mixed
    {
        return $request->query->get($name);
    }
}
