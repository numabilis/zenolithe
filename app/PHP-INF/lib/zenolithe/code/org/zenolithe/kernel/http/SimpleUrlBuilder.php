<?php
namespace org\zenolithe\kernel\http;

class SimpleUrlBuilder implements IUrlBuilder {
	protected $serverUrlPart = '';
	protected $applicationUrlPart = '';
	protected $moduleUrlPart = '';
	protected $moduleIndiceUrlPart = '';
	
	public function __construct() {
		$appName = substr($_SERVER['SCRIPT_FILENAME'], strlen($_SERVER['DOCUMENT_ROOT']));
		$this->applicationUrlPart = substr($appName, 0, strrpos($appName, '/') + 1);
		if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) {
			$this->serverUrlPart = 'https://'. $_SERVER['SERVER_NAME'];
		} else {
			$this->serverUrlPart = 'http://'. $_SERVER['SERVER_NAME'];
		}
	}
		
	public function getServerUrlPart() {
		return $this->serverUrlPart;
	}
	
  public function getApplicationUrlPart() {
    return $this->applicationUrlPart;
  }
	
	public function getModuleUrlPart() {
		return $this->moduleUrlPart;
	}
	
	public function setModuleUrlPart($moduleUrlPart) {
		$this->moduleUrlPart = $moduleUrlPart;
	}
	
	public function getModuleIndiceUrlPart() {
		return $this->moduleIndiceUrlPart;
	}
	
	public function setModuleIndiceUrlPart($moduleIndiceUrlPart) {
		$this->moduleIndiceUrlPart = $moduleIndiceUrlPart;
	}
	
	public function provideUrl($pageUrlPart, $lang=null) {
		$url = $this->serverUrlPart.$this->applicationUrlPart.$pageUrlPart;

		return $url;
	}
	
	public function getUrl($pageUrlPart, $lang=null) {
		return $this->provideUrl($pageUrlPart, $lang);
	}
	
	public function getBaseUrl() {
		return $this->getServerUrlPart().$this->getApplicationUrlPart();
	}
	
	public function getTranslatedUrl($lang) {
		return $this->provideTranslatedUrl($lang);
	}
}
?>
