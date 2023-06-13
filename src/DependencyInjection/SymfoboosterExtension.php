<?php

namespace Symfobooster\Base\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class SymfoboosterExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../../config/'));
        foreach ($this->getConfigFiles() as $configFile) {
            $loader->load($configFile);
        }
    }

    /**
     * @return string[]
     */
    private function getConfigFiles(): array
    {
        return [
            'services.yaml',
        ];
    }
}
