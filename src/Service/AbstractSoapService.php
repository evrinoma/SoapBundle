<?php

namespace Evrinoma\SoapBundle\Service;

use Evrinoma\SoapBundle\Annotation\Exclude;
use Evrinoma\SoapBundle\Manager\SoapServiceInterface;

/**
 * Class AbstractSoapService
 *
 * @package Evrinoma\SoapBundle\Service
 */
abstract class AbstractSoapService implements SoapServiceInterface
{

    protected $route = '';

    /**
     * @Exclude
     */
    public function getRoute(): string
    {
        return $this->route;
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
}