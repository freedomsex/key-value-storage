<?php


namespace FreedomSex\Services;


use Psr\Cache\CacheItemPoolInterface;

class KeyValueStorage
{
    use CounterStorage;

    public function __construct(CacheItemPoolInterface $memory)
    {
        $this->cache = $memory;
    }

    public function clear($key)
    {
        $this->cache->deleteItem($this->item($key));
    }

    public function item($key)
    {
        return $this->cache->getItem($key);
    }

    public function touch($key, $expires = null)
    {
        $value = $this->load($key);
        $this->save($key, $value, $expires);
    }

    public function load($key, $default = null)
    {
        return $this->item($key)->get();
    }

    public function save($key, $value, $expires = null)
    {
        $cacheItem = $this->item($key);
        $cacheItem->set($value);
        $cacheItem->expiresAfter($expires);
        $this->cache->save($cacheItem);
    }
}
