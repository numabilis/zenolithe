<?php
namespace org\zenolithe\kernel\locale;

use org\zenolithe\kernel\http\Request;

class LocaleResolverFromUrl implements ILocaleResolver {
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
		$found = false;
		$locale = $this->defaultLocale;
		$pos = 0;
		
		// Try to get locale from URL
		$pos = strpos($request->url, '/');
		if($pos) {
			$lang = substr($request->url, 0, $pos);
		} else {
			$lang = $request->url;
		}
		if(($request->url != '') && $lang) {
			$locale = $lang;
			if(strpos($this->supportedLocales, $locale.'/') !== false) {
				$request->url = substr($request->url, strlen($lang)+1);
				$found = true;
			} else {
				$locale = substr($locale, 0, 2);
				if(strpos($this->supportedLocales, $locale.'/') !== false) {
					$request->url = substr($request->url, strlen($lang)+1);
					$found = true;
				}
			}
		}
		// If not found in URL, try to get from session, headers or default
		if(!$found) {
			if($this->session->getAttribute('lang')) {
				$locale = $this->session->getAttribute('lang');
			} else if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
				$locale = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
			} else {
				$locale = $this->defaultLocale;
			}
		}
		$locale = strtr($locale, '_', '-');
		$this->session->setAttribute('lang', strtr($locale, '-', '_'));
		// TODO: remove this hack !
		if(strpos($this->supportedLocales, $locale.'/') === false) {
			$locale = substr($locale, 0, 2);
			if(strpos($this->supportedLocales, $locale.'/') === false) {
				$locale = $this->defaultLocale;
			}
		}
		
		return $locale;
	}
}
?>
