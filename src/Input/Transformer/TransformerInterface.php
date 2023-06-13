<?php

namespace Symfobooster\Base\Input\Transformer;

interface TransformerInterface
{
    public function transform(mixed $value): mixed;
}
