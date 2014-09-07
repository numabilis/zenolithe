<?php
namespace org\zenolithe\cms\plugins;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\controllers\IController;
use org\zenolithe\cms\page\PageModel;

class PluginController implements IController {
	public $view = 'dummy';
	public $requiredFile;
	public $variables = array();
	
	public function setRequiredFile($requiredFile) {
		$this->requiredFile = $requiredFile;
	}
	
	public function setVariables($variables) {
		$this->variables = $variables;
	}
	
	public function getTranslatedIndiceUrlPart($lang) {
		return '';
	}

	public function handleRequest(Request $request) {
		$model = new PageModel();
		foreach($this->variables as $key => $value) {
			$$key = $value;
		}
		require $this->requiredFile;
		$model->setViewName($this->view);

		return $model;
	}
}
?>
