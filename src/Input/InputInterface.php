<?php

namespace Symfobooster\Base\Input;

use Symfony\Component\Validator\Constraint;

interface InputInterface
{
    public static function getValidators(): Constraint;
}
