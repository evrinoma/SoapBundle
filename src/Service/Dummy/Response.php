<?php


namespace Evrinoma\SoapBundle\Service\Dummy;

/**
 * Class Response
 * в качестве ответа должен использоваться объект только публицными полями либо stdClass
 *
 * @package Evrinoma\SoapBundle\Dummy
 */
class Response
{
//region SECTION: Fields
    /**
     * @var string
     */
    public $recipient;
    /**
     * @var string
     */
    public $subject;
    /**
     * @var string
     */
    public $body;
//endregion Fields

//region SECTION: Constructor
    /**
     * MailAnswer constructor.
     *
     * @param string $recipient
     * @param string $subject
     * @param string $body
     */
    public function __construct(string $recipient, string $subject, string $body)
    {
        $this->recipient = $recipient;
        $this->subject   = $subject;
        $this->body      = $body;
    }
//endregion Constructor
}