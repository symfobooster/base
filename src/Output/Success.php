<?php

namespace Symfobooster\Base\Output;

class Success implements OutputInterface
{
    private mixed $data;

    public function __construct(mixed $data)
    {
        $this->data = $data;
    }

    public function getData(): array|object|string|null
    {
        return $this->data;
    }

    public function getCode(): int
    {
        return 200;
    }
}
