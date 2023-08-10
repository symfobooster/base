<?php

namespace Symfobooster\Base\Output;

class CreatedIdInt extends Created
{
    public int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
}
