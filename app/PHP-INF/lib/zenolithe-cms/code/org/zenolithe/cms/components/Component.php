<?php
namespace org\zenolithe\cms\components;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\IModel;
use org\zenolithe\kernel\mvc\controllers\IController;
use org\zenolithe\kernel\mvc\interceptors\IInterceptor;
use org\zenolithe\cms\page\IPageModel;

require 'code/org/zenolithe/cms/lang_helpers.php';

abstract class Component implements IInterceptor {
	public $id;
	public $substituteId;
	public $supportedLangs;
	public $parameter;
	public $zone;
	public $class;
	
	protected $controller = null;

	public function preHandle(Request $request, IController $controller) {
		$this->controller = $controller;
		return null;
	}

	public final function postHandle(Request $request, IController $controller, IModel $model) {
		$this->controller = $controller;
		
		if (($this->supportedLangs == 'all') || (strpos($this->supportedLangs, '/'.$request->getLocale().'/') !== false)) {
			$localModel = $this->getComponentModel($request, $model, $request->getLocale());
			$localModel->setViewName($this->viewName());
			$localModel->set('class', $this->class);
			$model->addContent($this->getZone(), $localModel);
		} else if ($this->id == $this->substituteId) {
			$langs = delegated_lang($request->getLocale());
			foreach ($langs as $lang) {
				if (strpos($this->supportedLangs, '/'.$lang.'/') !== false) {
					$localModel = $this->getComponentModel($request, $model, $lang);
					$localModel->setViewName($this->viewName());
					$localModel->set('class', $this->class);
					$model->addContent($this->getZone(), $localModel);
					break;
				}
			}
		} else if ($this->substituteId != 0) {
			$component = select_component_by_id($this->substituteId);
			if ($component) {
				$delegate =  new $component['cpt_class']();
				$delegate->id = $component['cpt_id'];
				$delegate->substituteId = $component['cpt_substitute_id'];
				$delegate->supportedLangs = $component['cpt_supported_langs'];
				$delegate->parameter = $component['cpt_parameter'];
				$delegate->zone = $this->getZone();
				$delegate->class = $this->class;
				$delegate->postHandle($request, $controller, $model);
			}
		}
	}

	public final function afterCompletion(Request $request, IController $controller) {
	}

	public function getZone() {
		return $this->zone;
	}

	public abstract function getComponentModel(Request $request, IPageModel $pageModel, $lang);

	public abstract function viewName();
}
?>
