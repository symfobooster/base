<?php

namespace Symfobooster\Base\Output\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class BadRequestMarker extends OutputMarker
{
    public int $status = 400;
}
