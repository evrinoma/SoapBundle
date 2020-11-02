<?php

namespace Evrinoma\SoapBundle\Subscriber;


use Doctrine\Common\Annotations\Reader;
use Evrinoma\SoapBundle\Event\SoapEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class SoapAnnotationSubscriber
 *
 * @package Evrinoma\SoapBundle\Subscriber
 */
class SoapAnnotationSubscriber implements EventSubscriberInterface
{
//region SECTION: Fields
    private $annotationReader;

    /**
     * FactoryDto
     */
    private $factoryDto;

//endregion Fields

//region SECTION: Constructor
    public function __construct(Reader $annotationReader)
    {
        $this->annotationReader = $annotationReader;
    }
//endregion Constructor

//region SECTION: Public
//endregion Public

//region SECTION: Private
    private function handleAnnotation($soap): void
    {
        $soapT[] = $soap;
//        $reflectionObject    = new ReflectionObject($soap);
//        $reflectionProperties = $reflectionObject->getProperties(ReflectionProperty::IS_PRIVATE);
//
//        foreach ($reflectionProperties as $reflectionProperty) {
//            $annotation = $this->annotationReader->getPropertyAnnotation($reflectionProperty, Dto::class);
//            if ($annotation instanceof Dto) {
//                $annotationDto = $this->factoryDto->createDto($annotation->class);
//                $dto->{'set'.ucfirst($reflectionProperty->getName())}($annotationDto);
//            }
//        }
    }
//endregion Private

//region SECTION: Dto
    public function onKernelSoap(SoapEvent $event): void
    {
        $soap = $event->getSoap();

        $this->handleAnnotation($soap);
    }
//endregion SECTION: Dto

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            SoapEvent::class => 'onKernelSoap',
        ];
    }
}