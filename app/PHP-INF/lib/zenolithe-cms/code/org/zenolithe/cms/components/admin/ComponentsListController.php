<?php
namespace org\zenolithe\cms\components\admin;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\SimpleModel;
use org\zenolithe\kernel\mvc\controllers\IController;

require daf_file('zenolithe/cms/components-admin.daf');

class ComponentsListController implements IController {
	public $view;
	public $componentRole;
	private $zenolitheRoot;
	private $componentsPath;
	
	public function setZenolitheRoot($zenolitheRoot) {
		$this->zenolitheRoot = $zenolitheRoot;
	}
	
	public function setComponentsPath($componentsPath) {
		$this->componentsPath = $componentsPath;
	}
	
	public function setView($view) {
		$this->view = $view;
	}
	
	public function setComponentRole($componentRole) {
		$this->componentRole = $componentRole;
	}
	
	public function handleRequest(Request $request) {
		$model = new SimpleModel();
		$componentsTypes = array();
		
		$domain = $request->getSession()->getAttribute('edited-domain');
		$model->set('edited_domain', $domain);
		$rootPath = $this->zenolitheRoot.'lib/';
		if(is_dir($rootPath)) {
			$entries = scandir($rootPath);
			if($entries) {
				foreach($entries as $entry) {
					if(($entry != '.') && ($entry != '..') && is_dir($rootPath.$entry)) {
						$folderPath = $rootPath.$entry.'/'.$this->componentsPath;
						if(is_dir($folderPath)) {
							if($folder = opendir($folderPath)) {
								while(($file = readdir($folder)) !== false) {
									if (pathinfo($file, PATHINFO_EXTENSION) != 'php') {
										continue;
									}
									require $folderPath.$file;
									if(in_array($this->componentRole, $component['roles'])) {
										$componentsTypes[] = $component;
									}
								}
							}
						}
					}
				}
			}
		}
		$model->set('components-types', $componentsTypes);
		$model->set('components-list', select_components_by_site_id_and_role($domain['dom_site_id'], $this->componentRole));
		$model->setViewName($this->view);
		
		return $model;
	}
}
?>
