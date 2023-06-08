<?php

namespace Zabachok\Symfobooster;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Zabachok\Symfobooster\DependencyInjection\SymfoboosterExtension;

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
