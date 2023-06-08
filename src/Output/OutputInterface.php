<?php

namespace Zabachok\Symfobooster\Output;

interface OutputInterface
{
    public function getData(): array|object|string|null;
    public function getCode(): int;
}
