<?php

namespace Symfobooster\Base;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Symfobooster\Base\DependencyInjection\SymfoboosterExtension;

class SymfoboosterBundle extends AbstractBundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new SymfoboosterExtension();
    }
//    public function getPath(): string
//    {
//        return dirname(__DIR__);
//    }
}
