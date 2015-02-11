<?php
namespace org\zenolithe\kernel\cache;

class XCache implements ICache {
	private $active = false;
	private $clearOnExit = false;
	
	public function setActive($active) {
		$this->active = $active;
	}
	
	public function getClearOnExit() {
		return $this->clearOnExit;
	}
	
	public function setClearOnExit($clearOnExit) {
		$this->clearOnExit = $clearOnExit;
	}
	
	public function clearUserCache() {
		xcache_clear_cache(XC_TYPE_VAR);
	}

	public function clearSystemCache() {
		apc_clear_cache(XC_TYPE_PHP);
	}
	
	public function fetch($key) {
		return xcache_get($key);
	}
	
	public function store($key, $value, $ttl=0) {
		return xcache_set($key, $value, $ttl);
	}
	
	public function exists($key) {
		return xcache_isset($key);
	}
	
	public function delete($key) {
		return xcache_unset($key);
	}
	
	public function inc($key) {
		return xcache_inc($key);
	}
	
	public function dec($key) {
		return xcache_dec($key);
	}
}
?>