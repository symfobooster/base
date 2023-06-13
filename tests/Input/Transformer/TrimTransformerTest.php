<?php

namespace Symfobooster\Base\Tests\Input\Transformer;

use PHPUnit\Framework\TestCase;
use Symfobooster\Base\Input\Transformer\TrimTransformer;

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
