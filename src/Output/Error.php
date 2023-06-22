<?php

namespace Symfobooster\Base\Output;

use Symfobooster\Base\Output\Attributes\ErrorMarker;
use Throwable;

#[ErrorMarker]
class Error implements OutputInterface
{
    public string $class;
    public string $message;
    public string $file;
    public int $line;
    public array $trace;

    public function __construct(Throwable $exception)
    {
        $this->class = get_class($exception);
        $this->message = $exception->getMessage();
        $this->file = $exception->getFile();
        $this->line = $exception->getLine();
        $this->trace = $exception->getTrace();
    }
}
