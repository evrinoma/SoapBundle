<?php


namespace Evrinoma\SoapBundle\Service\Dummy;

use Evrinoma\SoapBundle\Manager\SoapServiceInterface;
use Evrinoma\SoapBundle\Annotation\Exclude;

/**
 * Class I
 *
 * @package Evrinoma\SoapBundle\Service\Dummy
 */
class I implements SoapServiceInterface
{
    use Service;

//region SECTION: Getters/Setters
    /**
     * @Exclude
     */
    public function getRoute(): string
    {
        return mb_strtolower($this->getServiceName());
    }

    /**
     * @Exclude
     */
    public function getClass(): string
    {
        return static::class;
    }

    /**
     * @Exclude
     */
    public function getServiceName(): string
    {
        $reflect = new \ReflectionClass($this->getClass());

        return $reflect->getShortName();
    }
//endregion Getters/Setters
}