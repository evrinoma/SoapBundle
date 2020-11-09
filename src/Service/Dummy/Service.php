<?php

namespace Evrinoma\SoapBundle\Service\Dummy;

/**
 * Trait Service
 *
 * @package Evrinoma\SoapBundle\Service\Dummy
 */
trait Service
{
    /**
     * @param string $recipient
     * @param string $subject
     * @param string $messageBody
     *
     * @return Evrinoma\SoapBundle\Service\Dummy\Response
     */
    public function getResponse(string $recipient, string $subject, string $messageBody)
    {
        return new Response($recipient, $subject, $messageBody);
    }
}