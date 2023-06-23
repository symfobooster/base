<?php

namespace Symfobooster\Base\Output;

class CreatedInt extends Created
{
    public int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
}
