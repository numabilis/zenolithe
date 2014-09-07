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
}
?>