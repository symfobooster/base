<?php

namespace Symfobooster\Base\Input\Extractor;

use Symfony\Component\HttpFoundation\Request;

class FileExtractor implements ExtractorInterface
{
    public function extract(Request $request, string $name): mixed
    {
        return $request->files->get($name);
    }
}
