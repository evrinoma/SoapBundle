<?php


namespace Evrinoma\SoapBundle\Manager;


interface SoapManagerInterface
{
    public function getWsdl(string $route);
}