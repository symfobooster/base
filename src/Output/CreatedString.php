<?php

namespace Symfobooster\Base\Output;

class CreatedString extends Created
{
    public string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}
