<?php

namespace Zabachok\Symfobooster\Input\Extractor;

use Symfony\Component\HttpFoundation\Request;

class BodyExtractor implements ExtractorInterface
{
    private array $content;

    public function extract(Request $request, string $name): mixed
    {
        if (empty($this->content)) {
            $this->content = json_decode((string)$request->getContent(), true);
        }
        return $this->content[$name] ?? null;
    }
}
