<?php

namespace Evrinoma\SoapBundle\Manager;

use PHP2WSDL\PHPClass2WSDL;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class SoapManager
 *
 * @package Evrinoma\SoapBundle\Manager
 */
class SoapManager implements SoapManagerInterface
{

//region SECTION: Fields
    private $extension = '.wsdl';
    private $url;
    private $asFile;

    /**
     * @var SoapServiceInterface[]
     */
    private $soapServices = [];

    /**
     * @var string
     */
    private $connectionString;
//endregion Fields

//region SECTION: Constructor
    public function __construct(RequestStack $requestStack, array $params = [])
    {
        $this->url    = $requestStack->getCurrentRequest()->getSchemeAndHttpHost().( array_key_exists('url',$params) ? $params['url'] : '/soap/');
        $this->asFile = array_key_exists('redis',$params) ? true : false;
        $this->connectionString = array_key_exists('redis',$params)  ? $params['redis'] : null;
    }
//endregion Constructor

//region SECTION: Public
    public function addSoapService(SoapServiceInterface $service): void
    {
        $this->soapServices[$service->getRoute()] = $this->create($service);
    }
//endregion Public

//region SECTION: Private
    private function create(SoapServiceInterface $service)
    {
        /*
         * проверить еслить ли в кеш файл  всдл. Если файла нет, то создаем файл и загружаем его в кеш
         * если есть то
         */
        $wsdl = $this->generateWsdl($service->getRoute(), $service->getService());

        return '';
    }

    private function generateWsdl(string $route, string $class)
    {
        $wsdlGenerator = new PHPClass2WSDL($class, $this->url.$route);
        $wsdlGenerator->generateWSDL(true);
        $wsdl = $wsdlGenerator->dump();

        if ($this->asFile) {
            $wsdlGenerator->save($route.$this->extension);

            return $route.$this->extension;
        } else {

            return 'data://text/plain;base64,'.base64_encode($wsdl);
        }
    }
//endregion Private

//region SECTION: Getters/Setters
    public function getWsdl(string $route):string
    {
        if (array_key_exists($route, $this->soapServices)) {
            return $this->soapServices[$route];
        } else {
            throw new \Exception('Wsdl not found');
        }
    }
//endregion Getters/Setters
}