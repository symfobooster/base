<?php

namespace Symfobooster\Base\Input\Extractor;

use Symfony\Component\HttpFoundation\Request;

class ServerExtractor implements ExtractorInterface
{
    public function extract(Request $request, string $name): mixed
    {
        return $request->server->get($name);
    }
}
