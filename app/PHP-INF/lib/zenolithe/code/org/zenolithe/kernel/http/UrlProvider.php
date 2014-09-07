<?php
namespace org\zenolithe\kernel\http;

abstract class UrlProvider {
	static public $builder;

	static public function getServerUrlPart() {
		return self::$builder->getServerUrlPart();
	}
	
	static public function getModuleUrlPart() {
		return self::$builder->getModuleUrlPart();
	}
	
	static public function setModuleUrlPart($moduleUrlPart) {
		return self::$builder->setModuleUrlPart($moduleUrlPart);
	}
	
	static public function getModuleIndiceUrlPart() {
		return self::$builder->getModuleIndiceUrlPart();
	}
	
	static public function setModuleIndiceUrlPart($moduleIndiceUrlPart) {
		return self::$builder->setModuleIndiceUrlPart($moduleIndiceUrlPart);
	}
	
	static public function getBaseUrl() {
		return self::$builder->getServerUrlPart().self::$builder->getApplicationUrlPart();
	}

	static public function getUrl($pageUrlPart, $lang=null) {
		return self::$builder->provideUrl($pageUrlPart, $lang);
	}

	static public function getTranslatedUrl($lang) {
		return self::$builder->provideTranslatedUrl($lang);
	}

	abstract protected function provideUrl($pageUrlPart, $lang=null);
}
?>
