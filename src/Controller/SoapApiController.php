<?php

namespace Evrinoma\SoapBundle\Controller;


use Evrinoma\SoapBundle\Manager\SoapManagerInterface;
use Evrinoma\UtilsBundle\Controller\AbstractApiController;
use Evrinoma\UtilsBundle\Rest\RestTrait;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;
use JMS\Serializer\SerializerInterface;


/**
 * Class SoapApiController
 *
 * @package Evrinoma\SoapBundle\Controller
 */
final class SoapApiController extends AbstractApiController
{
//region SECTION: Fields
    /**
     * @var SoapManagerInterface
     */
    private $soapManager;
//endregion Fields

//region SECTION: Constructor
    /**
     * SoapApiController constructor.
     *
     * @param SerializerInterface  $serializer
     * @param SoapManagerInterface $soapManager
     */
    public function __construct(
        SerializerInterface $serializer,
        SoapManagerInterface $soapManager
    ) {
        parent::__construct($serializer);
        $this->soapManager = $soapManager;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @Rest\Get("/api/soap/get", name="api_get_soap")
     * @SWG\Get(tags={"soap service"})
     * @SWG\Response(response=200,description="Get soap services")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function menuGetAction()
    {
        return $this->json($this->soapManager->setRestSuccessOk()->getData(), $this->soapManager->getRestStatus());
    }
//endregion Public
}