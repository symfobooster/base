<?php

namespace Symfobooster\Base\Output;

class CreatedIdString extends Created
{
    public string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}
