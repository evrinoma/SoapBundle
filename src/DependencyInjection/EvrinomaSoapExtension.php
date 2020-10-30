<?php


namespace Evrinoma\SoapBundle\DependencyInjection;

use Evrinoma\SoapBundle\EvrinomaSoapBundle;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Variable;


/**
 * Class EvrinomaSoapExtension
 *
 * @package Evrinoma\SoapBundle\DependencyInjection
 */
class EvrinomaSoapExtension extends Extension
{
//region SECTION: Public
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $configuration = $this->getConfiguration($configs, $container);
        $config        = $this->processConfiguration($configuration, $configs);

        $url   = $config['url'];
        $cache = $config['cache'];

        $container->setParameter('evrinoma.soap.url', $url);

        $definition = $container->getDefinition('evrinoma.soap.manager');
        $definition->setArgument(1, new Reference($cache));
        $definition->setArgument(2, new Parameter('evrinoma.soap.url'));

        $alias = new Alias('evrinoma.soap.manager');
        $container->addAliases(['Evrinoma\SoapBundle\Manager\SoapManagerInterface' => $alias]);
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getAlias()
    {
        return EvrinomaSoapBundle::SOAP_BUNDLE;
    }
//endregion Getters/Setters
}