<?php

namespace Symfobooster\Base\Input;

use Symfobooster\Base\Input\Transformer\TransformerCollection;

interface TransformedFieldsInterface
{
    public function getTransformers(): TransformerCollection;
}
