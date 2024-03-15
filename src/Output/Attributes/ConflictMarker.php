<?php

namespace Symfobooster\Base\Output\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class ConflictMarker extends OutputMarker
{
    public int $status = 409;
}
