<?php


namespace FreedomSex\Services;


trait CounterStorage
{
    public function increment($key, $expires = null)
    {
        $counter = "counter_$key";
        $value = $this->load($counter, 0) + 1;
        $this->save($counter, $value, $expires);
    }

    public function decrement($key, $expires = null)
    {
        $counter = "counter_$key";
        $value = $this->load($counter, 0) - 1;
        $this->save($counter, $value, $expires);
    }

    public function count($key)
    {
        $counter = "counter_$key";
        return $this->load($counter, 0);
    }
}
