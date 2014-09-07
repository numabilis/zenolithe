<?php
namespace org\zenolithe\cms\i18n;

use org\zenolithe\kernel\i18n\IStringResolver;

require daf_file('zenolithe/i18n/strings.daf');

class DbStringResolver implements IStringResolver {
  private $domain;
  private $defaultLocale;
  private $strings = array();

  public function setDomain($domain) {
  	$this->domain = $domain;
  }

  public function setDefaultLocale($defaultLocale) {
  	$this->defaultLocale = $defaultLocale;
  }
  
	public function getString($key, $lang, $strict=false) {
		$string = '';

		if(!isset($this->domain->siteId)) {
			$siteId = 0;
		} else {
			$siteId = $this->domain->siteId;
		}
		if(isset($this->strings[$siteId][$lang][$key])) {
			$string = $this->strings[$siteId][$lang][$key];
		} else {
			$this->strings[$siteId][$lang] = select_strings($siteId, $lang);
			if(isset($this->strings[$siteId][$lang][$key])) {
				$string = $this->strings[$siteId][$lang][$key];
			} else if((!$strict) && ($lang != $this->defaultLocale)) {
				$string = $this->getString($key, $this->defaultLocale, $strict);
			} else {
				$this->strings[$siteId][$lang][$key] = '';
			}
		}

		return $string;
	}
}
?>
