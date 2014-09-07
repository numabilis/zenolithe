<?php
namespace org\zenolithe\kernel\locale;

use org\zenolithe\kernel\http\Request;

class LocaleResolverFromHttpHeaders implements ILocaleResolver {
	private $defaultLocale;
	private $supportedLocales;
	private $session;
	
	public function setDefaultLocale($defaultLocale) {
		$this->defaultLocale = $defaultLocale;
	}
	
	public function setSupportedLocales($supportedLocales) {
		$this->supportedLocales = $supportedLocales;
	}
	
	public function setSession($session) {
		$this->session = $session;
	}
	
	public function resolve(Request $request) {
		$locale = $this->defaultLocale;

		if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
			$locale = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
		}
		
		return $locale;
	}
}
?>
