<?php
namespace org\zenolithe\kernel\session;

interface ISession {
	public function getId();
	public function getAttributeNames();
	public function getAttribute($name);
	public function removeAttribute($name);
	public function setAttribute($name, $value);
	public function isNew();
}
?>
