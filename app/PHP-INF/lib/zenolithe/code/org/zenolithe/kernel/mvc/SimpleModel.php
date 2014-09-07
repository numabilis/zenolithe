<?php
namespace org\zenolithe\kernel\mvc;

use ArrayAccess;

class SimpleModel implements ArrayAccess, IModel {
	private $viewName;
	private $content = array();
	private $container = array();
	private $locale;

	public function __construct() {
		$this->set('model', $this);
	}
	
	public function get($name) {
		$value = null;
		
		if(isset($this->container[$name])) {
			$value = $this->container[$name];
		}
		
		return $value;
	}
	
	public function set($name, $value) {
		$this->container[$name] = $value;
	}
	
	public function getLocale() {
		return $this->locale;
	}
	
	public function setLocale($locale) {
		$this->locale = $locale;
	}
	
	public function getViewName() {
// 		return $this->viewName;
		return $this->container['viewName'];
	}
	
	public function setViewName($viewName) {
		$this->viewName = $viewName;
		$this->container['viewName'] = $viewName;
	}
	
	public function offsetSet($offset, $value) {
		if(is_null($offset)) {
			$this->container[] = $value;
		} else {
			$this->container[$offset] = $value;
		}
	}
	
	public function offsetExists($offset) {
		return isset($this->container[$offset]);
	}
	
	public function offsetUnset($offset) {
		unset($this->container[$offset]);
	}
	
	public function offsetGet($offset) {
		return isset($this->container[$offset]) ? $this->container[$offset] : null;
	}
}
?>