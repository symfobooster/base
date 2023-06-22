<?php

namespace Symfobooster\Base\Output\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class ErrorMarker extends OutputMarker
{
    public int $status = 500;
}
