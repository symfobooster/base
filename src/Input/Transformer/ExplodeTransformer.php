<?php

namespace Zabachok\Symfobooster\Input\Transformer;

class ExplodeTransformer implements TransformerInterface
{
    public const DEFAULT_SEPARATOR = ',';
    private string $separator;
    private int $limit;

    public function __construct(string $separator = self::DEFAULT_SEPARATOR, int $limit = PHP_INT_MAX)
    {
        $this->separator = $separator;
        $this->limit = $limit;
    }

    public function transform(mixed $value): array
    {
        return explode($this->separator, $value, $this->limit);
    }
}
