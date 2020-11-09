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
                'evrinoma.soap.settings.file.path' => ($settings['file']['path'] === '~') ? $container->getParameter('kernel.cache_dir') : $settings['file']['path'],
                'evrinoma.soap.settings.file.extension' => $settings['file']['extension'],
            ];

            $this->addDefinition('Evrinoma\SoapBundle\Cache\FileCache', 'evrinoma.file.cache', $this->toParams($arguments));
        }

        if ($settings['example']['dummy']) {
            $definition = $this->addDefinition('Evrinoma\SoapBundle\Service\Dummy\A', 'evrinoma.service.dummy.a', [], true);
            $definition->addTag('evrinoma.service.soap');

            $definition = $this->addDefinition('Evrinoma\SoapBundle\Service\Dummy\I', 'evrinoma.service.dummy.i', [], true);
            $definition->addTag('evrinoma.service.soap');


//            $definition = new Definition('Evrinoma\SoapBundle\Service\Dummy\A');
//            $definition
//                ->addTag('evrinoma.service.soap')
//                ->setPublic(true);
//            $alias      = new Alias('evrinoma.service.dummy.a');
//            $alias->setPublic(true);
//            $this->container->addDefinitions(['evrinoma.service.dummy.a' => $definition]);
//            $this->container->addAliases(['Evrinoma\SoapBundle\Service\Dummy\A' => $alias]);


        }

        $container->setParameter('evrinoma.soap.url', $url);

        $definition = $container->getDefinition('evrinoma.soap.manager');
        $definition->setArgument('$cache', new Reference($cache));
        $definition->setArgument('$url', new Parameter('evrinoma.soap.url'));

        $alias = new Alias('evrinoma.soap.manager');
        $container->addAliases(['Evrinoma\SoapBundle\Manager\SoapManagerInterface' => $alias]);

    }
//endregion Public

//region SECTION: Private
    /**
     * @param $arguments
     *
     * @return array
     */
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

    /**
     * @param string $className
     * @param string $aliasName
     * @param        $arguments
     * @param false  $public
     *
     * @return Definition
     */
    private function addDefinition(string $className,string $aliasName, $arguments, $public = false):Definition
    {
        $definition = new Definition($className);
        $alias      = new Alias($aliasName);

        if ($public) {
            $definition->setPublic(true);
            $alias->setPublic(true);
        }
        $this->container->addDefinitions([$aliasName => $definition]);
        $this->container->addAliases([$className => $alias]);

        foreach ($arguments as $key => $argument) {
            $definition->setArgument($key, $argument);
        }

        return $definition;
    }
//endregion Private

//region SECTION: Getters/Setters
    public function getAlias()
    {
        return EvrinomaSoapBundle::SOAP_BUNDLE;
    }
//endregion Getters/Setters
}