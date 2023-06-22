<?php

namespace Symfobooster\Base\Output\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class SuccessMarker extends OutputMarker
{
    public int $status = 200;
}
