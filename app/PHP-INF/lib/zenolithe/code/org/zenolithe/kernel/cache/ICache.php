<?php
namespace org\zenolithe\kernel\cache;

interface ICache {
	public function setActive($active);
	public function getClearOnExit();
	public function setClearOnExit($clearOnExit);
	public function clearUserCache();
	public function clearSystemCache();
	public function fetch($key);
	public function store($key, $value, $ttl=0);
	public function exists($key);
	public function delete($key);
	public function inc($key);
	public function dec($key);
}
?>