<?php

namespace Symfobooster\Base\Input\Extractor;

class ExtractorFactory
{
    private array $extractors;

    public function __construct(array $extractors)
    {
        $this->extractors = $extractors;
    }

    public function getExtractor(string $name): ExtractorInterface
    {
        if (!array_key_exists($name, $this->extractors)) {
            throw new \Exception('Undefined extractor');
        }
        return $this->extractors[$name];
    }
}
