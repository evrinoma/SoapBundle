<?php
namespace Evrinoma\SoapBundle\Cache;

use PHP2WSDL\PHPClass2WSDL;

/**
 * Class FileCache
 *
 * @package Evrinoma\SoapBundle\Cache
 */
class FileCache implements AdapterInterface
{
    private $extension = '.wsdl';

    public function has(string $key): bool
    {
        return file_exists ( $key.$this->extension ) ;
    }

    public function get(string $key): string
    {
        return $key.$this->extension;
    }

    public function set(PHPClass2WSDL $wsdlGenerator, string $key): bool
    {
        $status = $wsdlGenerator->save($key.$this->extension);

        return $status!==false;
    }
}