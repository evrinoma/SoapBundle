<?php


namespace Evrinoma\SoapBundle\Manager;

/**
 * Interface SoapManagerInterface
 *
 * @package Evrinoma\SoapBundle\Manager
 */
interface SoapManagerInterface
{
    public function getWsdl(string $key);
    public function getService(string $key): string;
}