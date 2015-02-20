<?php
namespace org\zenolithe\kernel\locale;

use org\zenolithe\kernel\http\Request;

class LocaleResolverFromSession implements ILocaleResolver {
	protected $defaultLocale;
	protected $sessionKey;
	
	public function setDefaultLocale($defaultLocale) {
		$this->defaultLocale = $defaultLocale;
	}
	
	public function setSessionKey($sessionKey) {
		$this->sessionKey = $sessionKey;
	}
	
	public function resolve(Request $request) {
		$locale = $this->defaultLocale;
		
		$sessionLocale = $request->getSession()->getAttribute($this->sessionKey);
		if($this->sessionKey) {
			$locale = $sessionLocale;
		} else if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
			$locale = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
		}
		
		return $locale;
	}
}
?>
