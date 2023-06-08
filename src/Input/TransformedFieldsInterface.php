<?php

namespace Zabachok\Symfobooster\Input;

use Zabachok\Symfobooster\Input\Transformer\TransformerCollection;

interface TransformedFieldsInterface
{
    public function getTransformers(): TransformerCollection;
}
