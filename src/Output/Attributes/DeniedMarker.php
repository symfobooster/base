<?php

namespace Symfobooster\Base\Output\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class DeniedMarker extends OutputMarker
{
    public int $status = 403;
}
