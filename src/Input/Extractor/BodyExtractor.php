<?php

namespace Symfobooster\Base\Input\Extractor;

use Symfobooster\Base\Input\Exception\InvalidBodyException;
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
                $content = json_decode((string)$request->getContent(), true);
                if ($content === null) {
                    throw new InvalidBodyException();
                }
                $this->content = $content;
            }
        }
        return $this->content[$name] ?? null;
    }
}
