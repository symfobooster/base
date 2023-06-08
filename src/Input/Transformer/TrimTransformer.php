<?php

namespace Zabachok\Symfobooster\Input\Transformer;

class TrimTransformer implements TransformerInterface
{
    private ?string $characters;

    public function __construct(string $characters = null)
    {
        $this->characters = $characters;
    }

    public function transform(mixed $value): string
    {
        $args = [$value];
        if (!is_null($this->characters)) {
            $args[] = $this->characters;
        }

        return call_user_func_array('trim', $args);
    }
}
