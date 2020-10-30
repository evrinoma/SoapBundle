<?php


namespace Evrinoma\SoapBundle\DependencyInjection;

use Evrinoma\SoapBundle\EvrinomaSoapBundle;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\DependencyInjection\Reference;


/**
 * Class EvrinomaSoapExtension
 *
 * @package Evrinoma\SoapBundle\DependencyInjection
 */
class EvrinomaSoapExtension extends Extension
{
//region SECTION: Fields
    private $container;
//endregion Fields

//region SECTION: Public
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $configuration   = $this->getConfiguration($configs, $container);
        $config          = $this->processConfiguration($configuration, $configs);
        $this->container = $container;
        $url             = $config['url'];
        $cache           = $config['cache'];
        $settings        = $config['settings'];


        if ($cache === 'evrinoma.redis.cache') {
            $arguments = [
                'evrinoma.soap.settings.redis.host' => $settings['redis']['host'],
                'evrinoma.soap.settings.redis.port' => $settings['redis']['port'],
            ];

            $this->addDefinition('Evrinoma\SoapBundle\Cache\RedisCache', 'evrinoma.redis.cache', $this->toParams($arguments));
        }

        if ($cache === 'evrinoma.file.cache') {
            $arguments = [
                'evrinoma.soap.settings.file.path' => $settings['file']['path'],
                'evrinoma.soap.settings.file.extension' => $settings['file']['extension'],
            ];

            $this->addDefinition('Evrinoma\SoapBundle\Cache\FileCache', 'evrinoma.file.cache', $this->toParams($arguments));
        }

        $container->setParameter('evrinoma.soap.url', $url);

        $definition = $container->getDefinition('evrinoma.soap.manager');
        $definition->setArgument(1, new Reference($cache));
        $definition->setArgument(2, new Parameter('evrinoma.soap.url'));

        $alias = new Alias('evrinoma.soap.manager');
        $container->addAliases(['Evrinoma\SoapBundle\Manager\SoapManagerInterface' => $alias]);

    }
//endregion Public

//region SECTION: Private
    private function toParams($arguments)
    {
        $params = [];

        foreach ($arguments as $key => $argument)
        {
            $this->container->setParameter($key,$argument);
            $params[] =new Parameter($key);
        }

        return $params;
    }

    private function addDefinition($className, $aliasName, $arguments)
    {
        $definition = new Definition($className);
        $alias      = new Alias($aliasName);
        $this->container->addDefinitions([$aliasName => $definition]);
        $this->container->addAliases([$className => $alias]);

        foreach ($arguments as $key => $argument) {
            $definition->setArgument($key, $argument);
        }
    }
//endregion Private

//region SECTION: Getters/Setters
    public function getAlias()
    {
        return EvrinomaSoapBundle::SOAP_BUNDLE;
    }
//endregion Getters/Setters
}