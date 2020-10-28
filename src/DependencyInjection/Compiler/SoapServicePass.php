<?php

namespace Evrinoma\SoapBundle\DependencyInjection\Compiler;


use Evrinoma\SoapBundle\Manager\SoapManager;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;


class SoapServicePass implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(SoapManager::class)) {
            return;
        }

        $definition = $container->findDefinition(SoapManager::class);

        $taggedServices = $container->findTaggedServiceIds('evrinoma.service.soap');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addSoapService', [new Reference($id)]);
        }
    }
}