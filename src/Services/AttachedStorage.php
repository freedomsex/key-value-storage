<?php


namespace FreedomSex\Services;


class AttachedStorage extends AbstractStorage
{
    use CounterStorage;

    const PREFIX = 'attached';

    public function wrapKey($key)
    {
        return self::PREFIX."_$key";
    }

    public function wrapItem($value, $point)
    {
        return [
            'value' => $value,
            'point' => $point
        ];
    }

    public function item($key)
    {
        return $this->cache->getItem($this->wrapKey($key));
    }

    public function extract($item, $index = 'value')
    {
        $wrapper = $item->get();
        if (!$wrapper or !is_array($wrapper)) {
            return null;
        }
        return $wrapper[$index];
    }

    public function load($key, $default = null)
    {
        return $this->extract($this->item($key)) ?? $default;
    }

    public function attach($item, $expires)
    {
        if (!$expires) {
            throw new Exception("Expires required");
        }
        if ($item->isHit()) {
            return $this->extract($item, 'point');
        } else {
            return $this->point($expires);
        }
    }

    public function save($key, $value, $expires)
    {
        $item = $this->item($key);
        $point = $this->attach($item, $expires);
        $item->set($this->wrapItem($value, $point));
        $this->saveItem($item, $point);
    }
}
