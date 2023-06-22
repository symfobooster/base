<?php

namespace Symfobooster\Base\Output;

use Symfobooster\Base\Output\Attributes\NotFoundMarker;

#[NotFoundMarker]
class NotFound implements OutputInterface
{
    public string $message;

    public function __construct(?string $message = null)
    {
        if (!is_null($message)) {
            $this->message = $message;
        }
    }
}
