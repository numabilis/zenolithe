<?php
namespace org\zenolithe\kernel\mvc\views;

class SimpleViewResolver implements IViewResolver {
	private $viewsPath;
	
	public function setViewsPath($viewsPath) {
		$this->viewsPath = $viewsPath;
	}
	
	public function resolve($name, $locale) {
		$view = null;

		$filename = $this->filepath($name, $locale);
		if($filename) {
			$view = new SimpleView();
			$view->setLocale($locale);
			$view->name = $filename;
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
