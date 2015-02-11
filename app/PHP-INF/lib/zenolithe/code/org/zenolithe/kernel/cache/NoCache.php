<?php
namespace org\zenolithe\kernel\cache;

class NoCache implements ICache {
	public function setActive($active) {
	}
	
	public function getClearOnExit() {
	}
	
	public function setClearOnExit($clearOnExit) {
	}
	
	public function clearUserCache() {
	}

	public function clearSystemCache() {
	}
	
	public function fetch($key) {
		return false;
	}
	
	public function store($key, $value, $ttl=0) {
		return false;
	}
	
	public function exists($key) {
		return false;
	}
	
	public function delete($key) {
		return false;
	}
	
	public function inc($key) {
		return false;
	}
	
	public function dec($key) {
		return false;
	}
}
?>