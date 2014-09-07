<?php
namespace org\zenolithe\kernel\mvc;

use org\zenolithe\kernel\bootstrap\IApplicationContext;

class ApplicationContext implements IApplicationContext {
	//private $debug = false;
	private $host;
	private $rootPath;
	private $zenolithePath;
 	//private $defaultLocale = 'en';
 	
	public function __construct() {
		$selfFile = __FILE__;
		$selfClassFile = str_replace('\\', '/', __CLASS__).'.php';
		$this->zenolithePath = substr($selfFile, 0, strpos($selfFile, $selfClassFile) - 4);
		$this->rootPath = substr($this->zenolithePath, 0, strlen($this->zenolithePath) - 8);
		$this->host = $_SERVER['SERVER_NAME'];
	}
	
	public function getHost() {
		return $this->host;
	}
	
	public function getRootPath() {
		return $this->rootPath;
	}
	
	public function getZenolithePath() {
		return $this->zenolithePath;
	}
}
?>