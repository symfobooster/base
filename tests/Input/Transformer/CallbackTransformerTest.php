<?php

namespace Symfobooster\Base\Tests\Input\Transformer;

use PHPUnit\Framework\TestCase;
use Symfobooster\Base\Input\Transformer\CallbackTransformer;

class CallbackTransformerTest extends TestCase
{
    public function testDefaultBehavior(): void
    {
        $shouldBeCalled = $this->getMockBuilder(\stdClass::class)
            ->addMethods(['__invoke'])
            ->getMock();
        $shouldBeCalled->expects($this->once())
            ->method('__invoke')
            ->with($this->equalTo('test'));

        /** @var callable $shouldBeCalled */
        $transformer = new CallbackTransformer($shouldBeCalled);
        $transformer->transform('test');
    }
}
