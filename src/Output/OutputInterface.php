<?php

namespace Symfobooster\Base\Output;

interface OutputInterface
{
    public function getData(): array|object|string|null;
    public function getCode(): int;
}
