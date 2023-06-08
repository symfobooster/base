<?php

namespace Zabachok\Symfobooster\Output;

use Throwable;

class Error implements OutputInterface
{
    private Throwable $exception;

    public function __construct(Throwable $exception)
    {
        $this->exception = $exception;
    }

    public function getData(): array|object|string|null
    {
        return [
            'class' => get_class($this->exception),
            'message' => $this->exception->getMessage(),
            'file' => $this->exception->getFile(),
            'line' => $this->exception->getLine(),
            'trace' => $this->exception->getTrace(),
        ];
        // TODO Add hiding data for production
    }

    public function getCode(): int
    {
        return 500;
    }
}
