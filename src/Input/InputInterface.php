<?php

namespace Symfobooster\Base\Input;

use Symfony\Component\Validator\Constraint;

interface InputInterface
{
    public function getValidators(): Constraint;
}
