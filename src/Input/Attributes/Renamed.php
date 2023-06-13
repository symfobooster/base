<?php

namespace Symfobooster\Base\Input\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Renamed
{
    public string $externalName;

    public function __construct(string $externalName)
    {
        $this->externalName = $externalName;
    }
}
