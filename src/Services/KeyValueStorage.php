<?php


namespace FreedomSex\Services;


class KeyValueStorage extends AbstractStorage
{
    use CounterStorage;

    public function save($key, $value, $expires = null)
    {
        $item = $this->item($key);
        $item->set($value);
        $this->saveItem($item, $this->point($expires));
    }
}
