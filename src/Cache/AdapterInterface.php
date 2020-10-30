<?php
namespace Evrinoma\SoapBundle\Cache;

use PHP2WSDL\PHPClass2WSDL;

/**
 * Interface AdapterInterface
 *
 * @package Evrinoma\SoapBundle\Cache
 */
interface AdapterInterface
{
    public function has(string $key):bool;
    public function get(string $key):string;
    public function set(PHPClass2WSDL $wsdlGenerator,string $key):bool;
}