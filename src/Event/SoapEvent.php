<?php

namespace Evrinoma\SoapBundle\Event;

use Evrinoma\SoapBundle\Annotation\Soap;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class DtoEvent
 *
 * @package Evrinoma\DtoBundle\Event
 */
class SoapEvent extends Event
{
//region SECTION: Fields
    /**
     * @var Soap
     */
    private $soap;
//endregion Fields


//region SECTION: Getters/Setters
    /**
     * @return Soap
     */
    public function getSoap()
    {
        return $this->soap;
    }

    /**
     * @param Soap $soap
     *
     * @return SoapEvent
     */
    public function setSoap(Soap $soap)
    {
        $this->soap = $soap;

        return $this;
    }
//endregion Getters/Setters

}