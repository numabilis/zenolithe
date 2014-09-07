<?php
namespace org\zenolithe\kernel\cache;

interface ICache {
	public function setActive($active);
	public function getClearOnExit();
	public function setClearOnExit($clearOnExit);
	public function clearUserCache();
}
?>