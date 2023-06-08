<?php

namespace Zabachok\Symfobooster\Tests\Input\Transformer;

use PHPUnit\Framework\TestCase;
use Zabachok\Symfobooster\Input\Transformer\ExplodeTransformer;

class ExplodeTransformerTest extends TestCase
{
    public function testDefaultBehavior(): void
    {
        $transformer = new ExplodeTransformer();
        $this->assertEquals(['1', '2'], $transformer->transform('1,2'));
    }

    public function testCustomSeparator(): void
    {
        $transformer = new ExplodeTransformer('-');
        $this->assertEquals(['1', '2'], $transformer->transform('1-2'));
    }

    public function testLimit(): void
    {
        $transformer = new ExplodeTransformer('-', 2);
        $this->assertEquals(['1', '2-3'], $transformer->transform('1-2-3'));
    }
}
