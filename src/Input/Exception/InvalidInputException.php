<?php

namespace Symfobooster\Base\Input\Exception;

use Exception;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class InvalidInputException extends Exception
{
    private ConstraintViolationListInterface $violationList;

    public function __construct(ConstraintViolationListInterface $violationList)
    {
        parent::__construct();
        $this->violationList = $violationList;
    }

    public function getViolationList(): ConstraintViolationListInterface
    {
        return $this->violationList;
    }

    public function __toString(): string
    {
        $messages = [];
        foreach ($this->violationList as $violation) {
            $messages[] = $violation->getPropertyPath() . ': ' . $violation->getMessage();
        }

        return implode("\n", $messages);
    }
}
