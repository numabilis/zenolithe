<?php
namespace org\zenolithe\kernel\mvc\views;

class SimpleViewResolver implements IViewResolver {
	protected $viewsPath;
	protected $stringResolver;
	
	public function setStringResolver($stringResolver) {
		$this->stringResolver = $stringResolver;
	}
	
	public function setViewsPath($viewsPath) {
		$this->viewsPath = $viewsPath;
	}
	
	public function resolve($name, $locale) {
		$view = null;

		$filename = $this->filepath($name, $locale);
		if($filename) {
			$view = new SimpleView();
			$view->setLocale($locale);
			$view->setStringResolver($this->stringResolver);
			$view->setName($filename);
		}

		return $view;
	}

	public function filepath($name, $locale) {
		$fileview = null;
		
		$filename = stream_resolve_include_path($this->viewsPath.$name.'.php');
		if($filename) {
			$fileview = $filename;
		} else {
			$filename = stream_resolve_include_path($this->viewsPath.$name);
			if($filename) {
				$fileview = $filename;
			}
		}

		return $fileview;
	}
}
?>
