<?php
namespace org\zenolithe\kernel\http;

use org\zenolithe\kernel\ioc\IocContainer;

// TODO : Refactor this class to merge it into Request
class RequestHelper {
	static private $_instance;
	private $request;
	private $uri;
	private $parameters;
	private $canonicalParameters = array();
	private $urlBuilder;
	
	static public function getInstance() {
		if(!self::$_instance) {
			self::$_instance = new RequestHelper();
			$request = IocContainer::getInstance()->get('context.request');
			self::$_instance->urlBuilder = IocContainer::getInstance()->get('urlBuilder');
			self::$_instance->request = $request;
			self::$_instance->uri = $request->url;
			self::$_instance->parameters = $request->getParameters();
		}
		
		return self::$_instance;
	}
	
	public function canonical() {
		$str = '';
		$separator = '';
		
		$parameters = $this->parameters;
		ksort($parameters);
		foreach($parameters as $key => $value) {
			if(in_array($key, $this->canonicalParameters)) {
				$str .= $separator . $key . '=' . $value;
				$separator = '&';
			}
		}
		if($str) {
			$str = '?'.$str;
		}
		
		return $this->urlBuilder->getUrl($this->uri).$str;
	}
	
	public function addCanonicalParameter($parameterName) {
		$this->canonicalParameters[] = $parameterName;
	}
	
	public function setUri($uri) {
		$this->uri = $uri;
	}
	
	public function url() {
		return $this->urlBuilder->getUrl($this->uri).$this->parameters();
	}
	
	public function addParameter($name, $value) {
		$this->modifyParameter($name, $value);
	}
	
	public function modifyParameter($name, $value) {
		$this->parameters[$name] = $value;
	}
	
	public function urlWithModifiedParameter($name, $value) {
		return $this->urlBuilder->getUrl($this->uri).$this->parametersWithModification($name, $value);
	}
	
	public function removeParameter($name) {
		unset($this->parameters[$name]);
	}
	
	public function urlWithRemovedParameter($name) {
		return $this->urlBuilder->getUrl($this->uri).$this->parametersWithRemoval($name);
	}
	
	public function parameter($name) {
		$str = '';
		
		if(isset($this->parameters[$name])) {
			$str = $this->parameters[$name];
		}
	
		return $str;
	}
	
	public function parameters() {
		$str = '';
		$separator = '';
		
		$parameters = $this->parameters;
		ksort($parameters);
		foreach($parameters as $key => $value) {
			$str .= $separator . $key . '=' . $value;
			$separator = '&';
		}
		if($str) {
			$str = '?'.$str;
		}
		
		return $str;
	}
	
	public function parametersWithModification($name, $value) {
		$str = '';
		$separator = '';
		
		$parameters = $this->parameters;
		$parameters[$name] = $value;
		ksort($parameters);
		foreach($parameters as $key => $value) {
			$str .= $separator . $key . '=' . $value;
			$separator = '&';
		}
		if($str) {
			$str = '?'.$str;
		}
		
		return $str;
	}
	
	public function parametersWithRemoval($name) {
		$str = '';
		$separator = '';
		
		$parameters = $this->parameters;
		ksort($parameters);
		foreach($parameters as $key => $value) {
			if($key != $name) {
				$str .= $separator . $key . '=' . $value;
				$separator = '&';
			}
		}
		if($str) {
			$str = '?'.$str;
		}
		
		return $str;
	}
	
	public function getRequest() {
		return $this->request;
	}
}
?>