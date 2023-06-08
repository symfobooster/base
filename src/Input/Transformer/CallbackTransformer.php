<?php

namespace Zabachok\Symfobooster\Input\Transformer;

class CallbackTransformer implements TransformerInterface
{
    private $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function transform(mixed $value): mixed
    {
        return ($this->callback)($value);
    }
}
