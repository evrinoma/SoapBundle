<?php

namespace Evrinoma\SoapBundle\Manager;


use Evrinoma\SoapBundle\Cache\CahceAdapterInterface;
use PHP2WSDL\PHPClass2WSDL;
use Symfony\Component\HttpFoundation\RequestStack;


/**
 * Class SoapManager
 *
 * @package Evrinoma\SoapBundle\Manager
 */
class SoapManager implements SoapManagerInterface
{

//region SECTION: Fields
    /**
     * @var string
     */
    private $url;

    /**
     * @var SoapServiceInterface[]
     */
    private $soapServices = [];

    /**
     * @var CahceAdapterInterface
     */
    private $cache;
//endregion Fields

//region SECTION: Constructor
    /**
     * SoapManager constructor.
     *
     * @param RequestStack          $requestStack
     * @param CahceAdapterInterface $cache
     * @param string|null           $url
     */
    public function __construct(RequestStack $requestStack, CahceAdapterInterface $cache, string $url)
    {
        $this->cache = $cache;
        $this->url   = ($url === '') ? $requestStack->getCurrentRequest()->getSchemeAndHttpHost().'/evrinoma/soap/' : $url;
    }
//endregion Constructor

//region SECTION: Public
    public function addSoapService(SoapServiceInterface $service): void
    {
        $this->soapServices[$service->getRoute()] = $this->create($service);
    }
//endregion Public

//region SECTION: Private
    private function create(SoapServiceInterface $service): string
    {
        if (!$this->cache->has($service->getRoute())) {
            $wsdlGenerator = $this->generateWsdl($service->getRoute(), $service->getClass());
            $this->cache->set($wsdlGenerator, $service->getRoute());
        }

        return $service->getClass();
    }

    private function generateWsdl(string $route, string $class): PHPClass2WSDL
    {
        $wsdlGenerator = new PHPClass2WSDL($class, $this->url.$route);
        $wsdlGenerator->generateWSDL(true);

        return $wsdlGenerator;
    }
//endregion Private

//region SECTION: Getters/Setters
    public function getWsdl(string $key): string
    {
        if (array_key_exists($key, $this->soapServices)) {
            return $this->cache->get($key);
        } else {
            throw new \Exception('Wsdl not found');
        }
    }

    public function getService(string $key): string
    {
        return array_key_exists($key, $this->soapServices) ? $this->soapServices[$key] : '';
    }
//endregion Getters/Setters
}