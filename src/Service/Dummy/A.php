<?php


namespace Evrinoma\SoapBundle\Service\Dummy;

use Evrinoma\SoapBundle\Annotation\Dummy;
use Evrinoma\SoapBundle\Service\AbstractSoapService;

/**
 * Class A
 *
 * @package Evrinoma\SoapBundle\Service\Dummy
 */
class A extends AbstractSoapService
{
    use Service;
//region SECTION: Fields
    protected $route = 'a';
//endregion Fields
}