<?php

namespace Symfobooster\Base\Output;

use Symfobooster\Base\Output\Attributes\CreatedMarker;

#[CreatedMarker]
class CreatedIdString extends Created
{
    public function __construct(public string $id)
    {
    }
}
