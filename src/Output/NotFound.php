<?php

namespace Symfobooster\Base\Output;

class NotFound implements OutputInterface
{
    private string $message;

    public function __construct(string $message = 'Not found')
    {
        $this->message = $message;
    }

    public function getData(): array|object|string|null
    {
        return $this->message;
    }

    public function getCode(): int
    {
        return 404;
    }
}
