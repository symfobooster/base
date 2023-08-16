<?php

namespace Symfobooster\Base\Output;

use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolation;

class InvalidHelper
{
    private ConstraintViolationList $violationList;

    public function __construct()
    {
        $this->violationList = new ConstraintViolationList();
    }

    public function with(string $filed, string $message): self
    {
        $violation = new ConstraintViolation($message, null, [], null, '[' . $filed . ']', null);
        $this->violationList->add($violation);

        return $this;
    }

    public function only(string $filed, string $message): ConstraintViolationList
    {
        return $this->with($filed, $message)->getList();
    }

    public function getList(): ConstraintViolationList
    {
        return $this->violationList;
    }
}
