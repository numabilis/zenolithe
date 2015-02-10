<?php
namespace org\zenolithe\kernel\mvc\views;

use org\zenolithe\kernel\mvc\IModel;

class SimpleView implements IView {
	private $locale;
  public $name;
  public $stringResolver;
  
  public function setStringResolver($stringResolver) {
   $this->stringResolver = $stringResolver;
  }
  
  public function setLocale($locale) {
  	$this->locale = $locale;
  }
  
  public function getString($key, $lang=null, $strict=false) {
  	if(!$lang) {
  		$lang = $this->locale;
  	}
  	
    return $this->stringResolver->getString($key, $lang, $strict);
  }
  
  public function render(IModel $model=null, $exception=null) {
    require($this->name);
  }
}
?>
