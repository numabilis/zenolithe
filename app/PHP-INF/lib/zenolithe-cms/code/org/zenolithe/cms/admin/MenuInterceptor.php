<?php
namespace org\zenolithe\cms\admin;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\IModel;
use org\zenolithe\kernel\mvc\controllers\IController;
use org\zenolithe\kernel\mvc\interceptors\IInterceptor;

class MenuInterceptor implements IInterceptor {
	private $selectedItem;
	private $zenolitheRoot;
	private $modulesPath;
	
	public function setZenolitheRoot($zenolitheRoot) {
		$this->zenolitheRoot = $zenolitheRoot;
	}
	
	public function setModulesPath($modulesPath) {
		$this->modulesPath = $modulesPath;
	}
	
	public function setSelectedItem($selectedItem) {
		$this->selectedItem = $selectedItem;
	}
	
	public function preHandle(Request $request, IController $controller) {
		return null;
	}

	public final function postHandle(Request $request, IController $controller, IModel $model) {
		$modules = array();
		
		$rootPath = $this->zenolitheRoot.'lib/';
		if(is_dir($rootPath)) {
			$entries = scandir($rootPath);
			if($entries) {
				foreach($entries as $entry) {
					if(($entry != '.') && ($entry != '..') && is_dir($rootPath.$entry)) {
						$folderPath = $rootPath.$entry.'/'.$this->modulesPath;
						if(is_dir($folderPath)) {
							if($folder = opendir($folderPath)) {
								while(($file = readdir($folder)) !== false) {
									if (pathinfo($file, PATHINFO_EXTENSION) != 'php') {
										continue;
									}
									require $folderPath.$file;
									$modules[] = $module;
								}
							}
						}
					}
				}
			}
		}
		$menu = $model->get('menu');
		if(!$menu) {
			$menu = array();
		}
		$menu['modules'] = $modules;
		$menu['selectedItem'] = $this->selectedItem;
		$model->set('menu', $menu);
	}

	public final function afterCompletion(Request $request, IController $controller) {
	}
}
?>