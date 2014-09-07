<?php
namespace org\zenolithe\cms\templating;

use org\zenolithe\kernel\mvc\views\IViewResolver;

class TemplateViewResolver implements IViewResolver {
	static public $templates = array('default');
	private $templatesPath;
	private $viewsPath;
	private $stringResolver;

	public function setTemplatesPath($templatesPath) {
		$this->templatesPath = $templatesPath;
	}
	
	public function setViewsPath($viewsPath) {
		$this->viewsPath = $viewsPath;
	}
	
  public function setStringResolver($stringResolver) {
    $this->stringResolver = $stringResolver;
  }

	public function resolve($name, $locale) {
		$view = null;

		$filename = $this->filepath($name, $locale);
		if($filename) {
			$view = new TemplateView();
      $view->setStringResolver($this->stringResolver);
      $view->setLocale($locale);
      $view->filename = $filename;
			$view->template = self::$templates[0];
		}

		return $view;
	}

	public function filepath($name, $locale) {
		$fileview = null;
		
		foreach(self::$templates as $template) {
			$filename = stream_resolve_include_path($this->templatesPath.$template.'/'.$name.'.php');
			if($filename) {
				break;
			}
		}
		if($filename) {
			$fileview = $filename;
		} else {
			$filename = stream_resolve_include_path($this->viewsPath.$name.'.php');
			if($filename) {
				$fileview = $filename;
			}
		}

		return $fileview;
	}
}
?>
