<?php

namespace Evrinoma\SoapBundle\Discovery;

use Doctrine\Common\Annotations\Reader;
use Evrinoma\SoapBundle\Annotation\Exclude;
use Evrinoma\SoapBundle\Manager\SoapServiceInterface;
use Zend\Soap\AutoDiscover;
use Zend\Soap\Wsdl;
use Zend\Soap\Wsdl\ComplexTypeStrategy\ComplexTypeStrategyInterface as ComplexTypeStrategy;

/**
 * Class CustomAutoDiscovery
 *
 * @package Evrinoma\SoapBundle\Discovery
 */
final class CustomAutoDiscovery extends AutoDiscover
{
    /**
     * @var Reader
     */
    private $annotationReader;

//region SECTION: Protected
    public function __construct(Reader $annotationReader, ComplexTypeStrategy $strategy = null, $endpointUri = null, $wsdlClass = null, array $classMap = [])
    {
        $this->annotationReader = $annotationReader;
        parent::__construct($strategy, $endpointUri, $wsdlClass, $classMap);
    }
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

    private function getExcludeMethods()
    {
        $public = [];

        $reflection    = new \ReflectionClass($this->class);
        $methods = $reflection->getMethods();
        foreach ($methods as $method)
        {
            $annotation = $this->annotationReader->getMethodAnnotation($method, Exclude::class);
            if ($annotation) {
                $name = $method->getName();
                $public[$name] = $name;
            }
        }

        return $public;
    }
}