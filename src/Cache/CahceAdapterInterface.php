<?php
namespace Evrinoma\SoapBundle\Cache;

use Zend\Soap\Wsdl;

/**
 * Interface AdapterInterface
 *
 * @package Evrinoma\SoapBundle\Cache
 */
interface CahceAdapterInterface
{
    public function has(string $key):bool;
    public function get(string $key):string;
    public function set(Wsdl $wsdlGenerator,string $key):bool;
}