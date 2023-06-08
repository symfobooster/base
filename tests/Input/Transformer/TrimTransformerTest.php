<?php

namespace Zabachok\Symfobooster\Tests\Input\Transformer;

use PHPUnit\Framework\TestCase;
use Zabachok\Symfobooster\Input\Transformer\TrimTransformer;

class TrimTransformerTest extends TestCase
{
    public function testDefaultBehavior(): void
    {
        $transformer = new TrimTransformer();
        $this->assertEquals('test', $transformer->transform('  test  '));
    }

    public function testCustomCharacter(): void
    {
        $transformer = new TrimTransformer('-');
        $this->assertEquals('test', $transformer->transform('--test--'));
    }
}
