<?php
namespace org\zenolithe\kernel\mvc\views;

use org\zenolithe\kernel\http\Url;
use org\zenolithe\kernel\mvc\IModel;

class SimpleView implements IView {
	protected $locale;
	protected $name;
	protected $stringResolver;

	public function setStringResolver($stringResolver) {
		$this->stringResolver = $stringResolver;
	}
	
	public function getLocale() {
		return $this->locale;
	}
	
	public function setLocale($locale) {
		$this->locale = $locale;
	}
	
	public function setName($name) {
		$this->name = $name;
	}
	
	public function getName() {
		return $this->name;
	}

	public function getString($key, $lang = null, $strict = false) {
		if(!$lang) {
			$lang = $this->locale;
		}
		
		return $this->stringResolver->getString($key, $lang, $strict);
	}

	public function render(IModel $model = null, $exception = null) {
		require ($this->name);
	}
	
	public function urlBase() {
		return Url::base();
	}
}
?>
