<?php

namespace Zabachok\Symfobooster\Input\Transformer;

interface TransformerInterface
{
    public function transform(mixed $value): mixed;
}
