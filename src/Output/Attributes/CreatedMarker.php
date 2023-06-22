<?php

namespace Symfobooster\Base\Output\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class CreatedMarker extends OutputMarker
{
    public int $status = 204;
}
