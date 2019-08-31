<?php
class Cache {
	private $cache;

	public function __construct($driver, $expire = 2592000) {
		$class = 'Cache\\' . $driver;

		if (class_exists($class)) {
			$this->cache = new $class($expire);
		} else {
			exit('Error: Could not load cache driver ' . $driver . ' cache!');
		}
	}

	public function get($key) {
		return $this->cache->get($key);
	}

	public function set($key, $value) {
		return $this->cache->set($key, $value);
	}

	public function delete($key) {
		return $this->cache->delete($key);
	}

    public function reset() {
        return $this->cache->reset();
    }
}
