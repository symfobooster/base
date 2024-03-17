<?php

namespace Symfobooster\Base\Tests\Input\Extractor;

use PHPUnit\Framework\TestCase;
use Symfobooster\Base\Input\Exception\InvalidBodyException;
use Symfobooster\Base\Input\Extractor\BodyExtractor;
use Symfony\Component\HttpFoundation\Request;

class BodyExtractorTest extends TestCase
{
    public function testSuccess(): void
    {
        $request = new Request([], [], [], [], [], ['CONTENT_TYPE' => 'application/json'], '{"key":"value"}');
        $extractor = new BodyExtractor();
        $result = $extractor->extract($request, 'key');
        $this->assertEquals('value', $result);
    }

    public function testInvalidJson(): void
    {
        $request = new Request([], [], [], [], [], ['CONTENT_TYPE' => 'application/json'], '{not-json}');
        $this->expectException(InvalidBodyException::class);
        $extractor = new BodyExtractor();
        $extractor->extract($request, 'key');
    }

    public function testNotExistKey(): void
    {
        $request = new Request([], [], [], [], [], ['CONTENT_TYPE' => 'application/json'], '{"key":"value"}');
        $extractor = new BodyExtractor();
        $result = $extractor->extract($request, 'key2');
        $this->assertNull($result);
    }

    public function testNoContent(): void
    {
        $request = new Request([], [], [], [], [], ['CONTENT_TYPE' => 'application/json']);
        $extractor = new BodyExtractor();
        $result = $extractor->extract($request, 'key');
        $this->assertNull($result);
    }
}
