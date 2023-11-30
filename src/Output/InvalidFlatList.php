<?php

namespace Symfobooster\Base\Output;

use Symfobooster\Base\Output\Attributes\BadRequestMarker;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

#[BadRequestMarker]
class Invalid
{
    public array $fields = [];

    public function __construct(ConstraintViolationListInterface $violationList)
    {
        foreach ($violationList as $violation) {
            /** @var ConstraintViolationInterface $violation */
            $field = substr($violation->getPropertyPath(), 1, -1);
            $messages[$field] = $violation->getMessage();
        }

        $this->fields = $messages;
    }
}
