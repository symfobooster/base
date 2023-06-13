<?php

namespace Symfobooster\Base\Output;

class Created implements OutputInterface
{
    public function getData(): array|object|string|null
    {
        return null;
    }

    public function getCode(): int
    {
        return 204;
    }
}
