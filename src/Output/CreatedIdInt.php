<?php

namespace Symfobooster\Base\Output;

use Symfobooster\Base\Output\Attributes\CreatedMarker;

#[CreatedMarker]
class CreatedIdInt extends Created
{
    public function __construct(public int $id)
    {
    }
}
