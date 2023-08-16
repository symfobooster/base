<?php

namespace Symfobooster\Base\Input\Extractor;

use Symfony\Component\HttpFoundation\Request;

class BodyExtractor implements ExtractorInterface
{
    private array $content;

    public function extract(Request $request, string $name): mixed
    {
        if ($request->getContentTypeFormat() === 'form') {
            return $request->getPayload()->get($name);
        }

        if (empty($this->content)) {
            $content = $request->getContent();
            if (empty($content)) {
                $this->content = [];
            } else {
                $this->content = json_decode((string)$request->getContent(), true);
            }
        }
        return $this->content[$name] ?? null;
    }
}
