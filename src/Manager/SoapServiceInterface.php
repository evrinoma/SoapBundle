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
    public function getRoute(): string;

    public function getClass(): string;
//endregion Getters/Setters
}