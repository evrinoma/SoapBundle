<?php


namespace Evrinoma\SoapBundle\Controller;

use Evrinoma\SoapBundle\Manager\SoapManager;
use Evrinoma\SoapBundle\Manager\SoapManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SoapController
 * @Route("/soap")
 *
 * @package Evrinoma\SoapBundle\Controller
 */
class SoapController extends AbstractController
{
//region SECTION: Fields
    /**
     * @var SoapManagerInterface
     */
    protected $soapManager;
//endregion Fields

//region SECTION: Public
    /**
     * @Route("/{name}", defaults={"_format"="xml"}, name="soap_route", options={"expose"=true})
     * @param string $name
     *
     * @return Response
     */
    public function soapAction(string $name)
    {
        if ($this->has($name)) {

            $wsdl        = $this->soapManager->getWsdl($name);
            $soapService = $this->get($name);

            $soapServer = new \SoapServer($wsdl, ['soap_version' => SOAP_1_2]);

            $soapServer->setObject($soapService);

            return $this->getSoapServerResponse($soapServer);
        }

        throw new \Exception('Service ['.$name.'] isn\'t registered');
    }
//endregion Public

//region SECTION: Private
    /**
     * @param $soapServer
     *
     * @return Response
     */
    private function getSoapServerResponse(\SoapServer $soapServer)
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=UTF-8');
        ob_start();
        $soapServer->handle();
        $response->setContent(ob_get_clean());

        return $response;
    }
//endregion Private

//region SECTION: Getters/Setters
    /**
     * @internal
     * @required
     */
    public function setSoapManager(SoapManagerInterface $soapManager): ?SoapManagerInterface
    {
        $previous          = $this->soapManager;
        $this->soapManager = $soapManager;

        return $previous;
    }
//endregion Getters/Setters
}