<?php

namespace Evrinoma\SoapBundle\Cache;

use Symfony\Component\Cache\Adapter\RedisAdapter;
use Zend\Soap\Wsdl;

/**
 * Class RedisCache
 *
 * @package Evrinoma\SoapBundle\Cache
 */
class RedisCache implements CahceAdapterInterface
{
//region SECTION: Fields
    /**
     * @inheritdoc
     */
    private $cache;
//endregion Fields

//region SECTION: Constructor
    /**
     * RedisCache constructor.
     *
     * @param string $host
     * @param string $port
     */
    public function __construct(string $host, string $port)
    {
        $redisConnection = RedisAdapter::createConnection('redis://'.$host.':'.$port);

        $this->cache = new RedisAdapter($redisConnection, $namespace = '', 0);
    }
//endregion Constructor

//region SECTION: Public
    public function has(string $key): bool
    {
        return $this->cache->hasItem($key);
    }
//endregion Public

//region SECTION: Getters/Setters
    public function get(string $key): string
    {
        $value     = '';
        $cacheItem = $this->cache->getItem($key);
        if ($cacheItem->isHit()) {
            $value = $cacheItem->get();
        }

        return 'data://text/plain;base64,'.base64_encode($value);
    }

    public function set(Wsdl $wsdlGenerator, string $key): bool
    {
        $wsdl = $wsdlGenerator->toXml();

        $cacheItem = $this->cache->getItem($key);
        $cacheItem->set($wsdl);

        return $this->cache->save($cacheItem);
    }
//endregion Getters/Setters
}