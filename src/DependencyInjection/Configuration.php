<?php


namespace Evrinoma\SoapBundle\DependencyInjection;

use Evrinoma\SoapBundle\EvrinomaSoapBundle;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;


class Configuration implements ConfigurationInterface
{
//region SECTION: Getters/Setters
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder(EvrinomaSoapBundle::SOAP_BUNDLE);
        $rootNode    = $treeBuilder->getRootNode();

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('url')->defaultValue('')
                ->info('This option is used for custom Url Soap server')
                ->end()
                ->scalarNode('cache')->defaultValue('evrinoma.redis.cache')
                ->info('This option is used for plugins cache service')
            ->end();
        $rootNode->children()
                ->arrayNode('settings')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('redis')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('host')->defaultValue('localhost')->end()
                                ->scalarNode('port')->defaultValue('6379')->end()
                            ->end()
                        ->end()
                        ->arrayNode('file')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('extension')->defaultValue('wsdl')->info('Wsdl file extension')->end()
                                ->scalarNode('path')->defaultValue('~')->info('path to cache directory')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
//endregion Getters/Setters
}
