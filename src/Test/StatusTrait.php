<?php

namespace Symfobooster\Base\Test;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @mixin ClientTrait
 * @mixin WebTestCase
 */
trait StatusTrait
{
    protected function checkSuccess(): void
    {
        $this->assertEquals(200, $this->browser->getResponse()->getStatusCode());
        $this->assertIsArray($this->content);
    }
}