<?php

namespace Symfobooster\Base\Tests\Input\Transformer;

use PHPUnit\Framework\TestCase;
use Symfobooster\Base\Input\Transformer\CallbackTransformer;
use Symfobooster\Base\Input\Transformer\Exception\InvalidTransformerException;
use Symfobooster\Base\Input\Transformer\Exception\TransformersNotFoundException;
use Symfobooster\Base\Input\Transformer\ExplodeTransformer;
use Symfobooster\Base\Input\Transformer\TransformerCollection;
use Symfobooster\Base\Input\Transformer\TrimTransformer;

class TransformerCollectionTest extends TestCase
{
    public function testDefaultBehavior(): void
    {
        $trimTransformer = new TrimTransformer();
        $explodeTransformer = new ExplodeTransformer();
        $callbackTransformer = new CallbackTransformer(function () {
        });

        $collection = new TransformerCollection([
            'field1' => [$trimTransformer, $explodeTransformer],
            'field2' => [$callbackTransformer],
        ]);

        $field1Transformers = $collection->getTransformersByField('field1');
        $this->assertCount(2, $field1Transformers);
        $this->assertSame($trimTransformer, $field1Transformers[0]);
        $this->assertSame($explodeTransformer, $field1Transformers[1]);

        $field2Transformers = $collection->getTransformersByField('field2');
        $this->assertCount(1, $field2Transformers);
        $this->assertSame($callbackTransformer, $field2Transformers[0]);
    }

    public function testWrongField(): void
    {
        $this->expectException(InvalidTransformerException::class);

        new TransformerCollection([
            [new TrimTransformer()],
        ]);
    }

    public function testWrongTransformer(): void
    {
        $this->expectException(InvalidTransformerException::class);

        new TransformerCollection([
            'field' => [
                new class {
                }
            ],
        ]);
    }

    public function testHasNoField(): void
    {
        $collection = new TransformerCollection([
            'field' => [new TrimTransformer()],
        ]);
        $this->expectException(TransformersNotFoundException::class);

        $collection->getTransformersByField('not-exists');
    }
}
