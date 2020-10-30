<?php


namespace Evrinoma\SoapBundle;

use Evrinoma\MenuBundle\DependencyInjection\Compiler\MenuItemPass;
use Evrinoma\SoapBundle\DependencyInjection\Compiler\SoapServicePass;
use Evrinoma\SoapBundle\DependencyInjection\EvrinomaSoapExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EvrinomaSoapBundle extends Bundle
{

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $soapCompilerClass = 'Evrinoma\SoapBundle\DependencyInjection\Compiler\SoapServicePass';
        if (class_exists($soapCompilerClass)) {
            $container->addCompilerPass(new SoapServicePass());
        }
    }
//region SECTION: Getters/Setters
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new EvrinomaSoapExtension();
        }

        return $this->extension;
    }
//endregion Getters/Setters
}