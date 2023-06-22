<?php

namespace Symfobooster\Base\Output\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class NotFoundMarker extends OutputMarker
{
    public int $status = 404;
}
