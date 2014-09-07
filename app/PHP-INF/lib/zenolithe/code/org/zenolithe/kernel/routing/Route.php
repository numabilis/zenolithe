<?php
namespace org\zenolithe\kernel\routing;

class Route {
	private $controller;
	private $interceptors = array();
	
	public function getController() {
		return $this->controller;
	}
	
	public function setController($controller) {
		$this->controller = $controller;
	}
	
	public function getInterceptors() {
		return $this->interceptors;
	}
	
	public function addInterceptors($interceptors) {
		$this->interceptors = array_merge($this->interceptors, $interceptors);
	}
}
?>