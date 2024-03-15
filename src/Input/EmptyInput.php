<?php

namespace Symfobooster\Base\Input;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints as Assert;

class EmptyInput implements InputInterface
{
    public static function getValidators(): Constraint
    {
        return new Assert\Collection([]);
    }
}
