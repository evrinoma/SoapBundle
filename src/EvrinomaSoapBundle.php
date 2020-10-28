<?php


namespace Evrinoma\SoapBundle;

use Evrinoma\SoapBundle\DependencyInjection\EvrinomaSoapExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EvrinomaSoapBundle extends Bundle
{

//region SECTION: Getters/Setters
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new EvrinomaSoapExtension();
        }

        return $this->extension;
    }
//endregion Getters/Setters
}