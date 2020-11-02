<?php

namespace Evrinoma\SoapBundle\Discovery;

use Evrinoma\SoapBundle\Manager\SoapServiceInterface;
use Zend\Soap\AutoDiscover;
use Zend\Soap\Wsdl;

/**
 * Class CustomAutoDiscovery
 *
 * @package Evrinoma\SoapBundle\Discovery
 */
final class CustomAutoDiscovery extends AutoDiscover
{
//region SECTION: Protected
    /**
     * Generate the WSDL for a service class.
     *
     * @return Wsdl
     */
    protected function generateClass()
    {
        $methods = [];

        $excluded = $this->getExcludeMethods();

        foreach ($this->reflection->reflectClass($this->class)->getMethods() as $method) {
            if (!(array_key_exists($method->getName(), $excluded))) {
                $methods[] = $method;
            }
        }

        return $this->generateWsdl($methods);
    }
//endregion Protected

//region SECTION: Private
    private function getExcludeMethods()
    {
        $methods = [];

        $interface = new \ReflectionClass(SoapServiceInterface::class);

        array_filter(
            $interface->getMethods(),
            function ($object) use (&$methods) {
                $methods [$object->name] = $object->name;
            }
        );

        return $methods;
    }
//endregion Private
}