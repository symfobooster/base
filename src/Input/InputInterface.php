<?php

namespace Zabachok\Symfobooster\Input;

use Symfony\Component\Validator\Constraint;

interface InputInterface
{
    public function getValidators(): Constraint;
}
