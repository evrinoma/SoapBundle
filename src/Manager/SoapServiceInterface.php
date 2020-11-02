<?php
namespace Evrinoma\SoapBundle\Manager;

/**
 * Interface SoapServiceInterface
 *
 * @package Evrinoma\SoapBundle\Manager
 */
interface SoapServiceInterface
{
//region SECTION: Getters/Setters
    /**
     * @Exclude
     *
     * @return string
     */
    public function getRoute(): string;

    /**
     * @Exclude
     *
     * @return string
     */
    public function getClass(): string;

    /**
     * @Exclude
     *
     * @return string
     */
    public function getServiceName():string;
//endregion Getters/Setters
}