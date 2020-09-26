<?php


namespace FreedomSex\Services;


use Psr\Cache\CacheItemPoolInterface;

class AbstractStorage
{
    public function __construct(CacheItemPoolInterface $memory)
    {
        $this->cache = $memory;
    }

    public function clear()
    {
        $this->cache->clear();
    }

    public function deleteItem($key)
    {
        $this->cache->deleteItem($key);
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
        return $this->item($key)->get() ?? $default;
    }

    public function point($expires)
    {
        if ($expires) {
            return new \DateTime('+'.$expires.' seconds');
        }
        return null;
    }

    protected function saveItem($item, \DateTimeInterface $expires = null)
    {
        if ($expires) {
            $item->expiresAt($expires);
        }
        $this->cache->save($item);
    }

}
