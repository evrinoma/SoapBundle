<?php

namespace Evrinoma\SoapBundle\Manager;


use Evrinoma\SoapBundle\Cache\CahceAdapterInterface;
use Evrinoma\SoapBundle\Discovery\CustomAutoDiscovery;
use Evrinoma\UtilsBundle\Manager\AbstractBaseManager;
use Evrinoma\UtilsBundle\Rest\RestTrait;
use Symfony\Component\HttpFoundation\RequestStack;
use Zend\Soap\Wsdl;


/**
 * Class SoapManager
 *
 * @package Evrinoma\SoapBundle\Manager
 */
class SoapManager extends AbstractBaseManager implements SoapManagerInterface
{
    use RestTrait;

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

    /**
     * @var CustomAutoDiscovery
     */
    private $autoDiscover;
//endregion Fields

//region SECTION: Constructor
    /**
     * SoapManager constructor.
     *
     * @param CustomAutoDiscovery   $customAutoDiscovery
     * @param RequestStack          $requestStack
     * @param CahceAdapterInterface $cache
     * @param string                $url
     */
    public function __construct(CustomAutoDiscovery $customAutoDiscovery, RequestStack $requestStack, CahceAdapterInterface $cache, string $url)
    {
        $this->autoDiscover = $customAutoDiscovery;
        $this->cache        = $cache;
        $this->url          = ($url === '') ? $requestStack->getCurrentRequest()->getSchemeAndHttpHost().'/evrinoma/soap/' : $url;
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
            $wsdlGenerator = $this->generateWsdl($service->getRoute(), $service->getClass(), $service->getServiceName());
            $this->cache->set($wsdlGenerator, $service->getRoute());
        }

        return $service->getClass();
    }

    private function generateWsdl(string $route, string $class, string $serviceName): Wsdl
    {
        $this->autoDiscover
            ->setClass($class)
            ->setUri($this->url.$route)
            ->setServiceName($serviceName);

        return $this->autoDiscover->generate();
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

    public function getData()
    {
       return $this->soapServices;
    }

//endregion Getters/Setters
    public function getRestStatus(): int
    {
        return $this->status;
    }
}