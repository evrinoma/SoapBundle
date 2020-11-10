<?php


namespace Evrinoma\SoapBundle\Manager;

use Evrinoma\UtilsBundle\Manager\BaseInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;

/**
 * Interface SoapManagerInterface
 *
 * @package Evrinoma\SoapBundle\Manager
 */
interface SoapManagerInterface extends RestInterface, BaseInterface
{
    public function getWsdl(string $key);
    public function getService(string $key): string;
}