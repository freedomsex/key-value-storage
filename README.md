# Key-Value Storage

A simple key-value storage based on PSR-6, Caching Interface. 
Inspired by \Memcached() 

```yaml
# Symfony config cache.yaml

framework:
  cache:
    default_memcached_provider: 'memcached://localhost'
    pools:
      memory:
        adapter: cache.adapter.memcached
        public: true
```

```php
use FreedomSex\Services\KeyValueStorage;

// ...

public function __construct(KeyValueStorage $storage) 
{
    $this->storage = $storage;
}

// ...

$storage->save($key, $value, $expires = null);
$storage->load($key, $default = null);

////
// See source
////

// touch, item, clear
// [CounterStorage trait] increment, decrement, count
```

