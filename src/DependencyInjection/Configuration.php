<?php


namespace Evrinoma\SoapBundle\DependencyInjection;

use Evrinoma\SoapBundle\EvrinomaSoapBundle;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;


class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder(EvrinomaSoapBundle::SOAP_BUNDLE);
        $rootNode    = $treeBuilder->getRootNode();

        $rootNode
            ->children()
            ->scalarNode('url')->defaultValue('')
            ->info('This option is used for custom Url Soap server')
            ->end()
            ->scalarNode('cache')->defaultValue('evrinoma.redis.cache')
            ->info('This option is used for plugins cache service')
            ->end();

        return $treeBuilder;
    }
}
