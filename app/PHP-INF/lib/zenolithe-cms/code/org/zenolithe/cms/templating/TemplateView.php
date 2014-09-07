<?php
namespace org\zenolithe\cms\templating;

use org\zenolithe\kernel\mvc\views\IView;
use org\zenolithe\kernel\mvc\IModel;

class TemplateView implements IView {
	private $locale;
	public $filename;
	public $template;
  private $stringResolver;
  
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
  
	public function render(IModel $model, $exception = null) {
		require($this->filename);
	}
}
?>
