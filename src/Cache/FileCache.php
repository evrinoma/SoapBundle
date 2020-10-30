<?php

namespace Evrinoma\SoapBundle\Cache;

use PHP2WSDL\PHPClass2WSDL;

/**
 * Class FileCache
 *
 * @package Evrinoma\SoapBundle\Cache
 */
class FileCache implements CahceAdapterInterface
{
//region SECTION: Fields
    private $extension = '.wsdl';
    private $path;
//endregion Fields

//region SECTION: Constructor
    /**
     * FileCache constructor.
     *
     * @param string $path
     * @param string $extension
     */
    public function __construct(string $path, string $extension)
    {
        $this->path      = $path === '~' ? '' : $path;
        $this->extension = '.'.$extension;
    }
//endregion Constructor

//region SECTION: Public
    public function has(string $key): bool
    {
        return file_exists($this->path.$key.$this->extension);
    }
//endregion Public

//region SECTION: Getters/Setters
    public function get(string $key): string
    {
        return $this->path.$key.$this->extension;
    }

    public function set(PHPClass2WSDL $wsdlGenerator, string $key): bool
    {
        $status = $wsdlGenerator->save($this->path.$key.$this->extension);

        return $status !== false;
    }
//endregion Getters/Setters
}