<?php

namespace Zabachok\Symfobooster\Input\Extractor;

class ExtractorFactory
{
    private array $extractors;

    public function __construct(array $extractors)
    {
        $this->extractors = $extractors;
    }

    public function getExtractor(string $name): ExtractorInterface
    {
        return $this->extractors[$name];
    }
}
