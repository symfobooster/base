<?php

namespace Zabachok\Symfobooster\Input\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Source
{
    public string $source;

    public function __construct(string $source)
    {
        $this->source = $source;
    }
}
