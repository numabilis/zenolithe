<?php
namespace org\zenolithe\kernel\http;

use org\zenolithe\kernel\ioc\IocContainer;

class Url {
	static private $_instance;
	protected $scheme;
	protected $host;
	protected $documentRoot;
	protected $script;
	protected $parameters = array();
	protected $canonicalParameters = array();
	
	public function __construct() {
		$iocContainer = IocContainer::getInstance();
// 		$appName = substr($_SERVER['SCRIPT_FILENAME'], strlen($_SERVER['DOCUMENT_ROOT']));
// 		$this->documentRoot = substr($appName, 0, strrpos($appName, '/') + 1);
		$this->documentRoot = $iocContainer->get('application.base');
		if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) {
			$this->scheme = 'https';
		} else {
			$this->scheme = 'http';
		}
		$this->host = $_SERVER['SERVER_NAME'];
	}
	
	public function getScript() {
		return $this->script;
	}
	
	public function setScript($script) {
		$this->script = $script;
	}
	
	public function getParameters() {
		return $this->parameters;
	}
	
	public function setParameters(array $parameters) {
		$this->parameters = $parameters;
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
	
		return $this->scheme.'://'.$this->host.$this->documentRoot.$this->script.$str;
	}

	public function url() {
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
	
		return $this->scheme.'://'.$this->host.$this->documentRoot.$this->script.$str;
	}
	
	private static function getInstance() {
		if(self::$_instance == null) {
			self::$_instance = new Url();
		}
		
		return self::$_instance;
	}
	
	public static function base() {
		$instance = self::getInstance();
		
		return $instance->scheme.'://'.$instance->host.$instance->documentRoot;
	}
}