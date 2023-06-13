<?php

namespace Symfobooster\Base\Output;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class Invalid implements OutputInterface
{
    private ConstraintViolationListInterface $violationList;

    public function __construct(ConstraintViolationListInterface $violationList)
    {
        $this->violationList = $violationList;
    }

    public function getData(): array|object|string|null
    {
        $messages = [];

        foreach ($this->violationList as $violation) {
            /** @var ConstraintViolationInterface $violation */
            $field = substr($violation->getPropertyPath(), 1, -1);
            $messages[$field][] = $violation->getMessage();
        }

        return ['fields' => $messages];
    }

    public function getCode(): int
    {
        return 400;
    }
}
