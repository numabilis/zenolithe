<?php
namespace org\zenolithe\kernel\cache;

class ApcCache implements ICache {
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
		apc_clear_cache('user');
	}
	
	public function clearSystemCache() {
		apc_clear_cache('system');
	}
	
	public function fetch($key) {
		return apc_fetch($key);
	}
	
	public function store($key, $value, $ttl=0) {
		return apc_store($key, $value, $ttl);
	}
	
	public function exists($key) {
		return apc_exists($key);
	}
	
	public function delete($key) {
		return apc_delete($key);
	}
	
	public function inc($key) {
		return apc_inc($key);
	}
	
	public function dec($key) {
		return apc_dec($key);
	}
}
?>