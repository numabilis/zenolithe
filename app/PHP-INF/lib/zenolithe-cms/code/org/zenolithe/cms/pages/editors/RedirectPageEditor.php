<?php
namespace org\zenolithe\cms\pages\editors;

use org\zenolithe\kernel\mvc\forms\SimpleFormModel;
use org\zenolithe\cms\pages\editors\PageEditor;
use org\zenolithe\kernel\mvc\forms\IFormModel;

class RedirectPageEditor extends PageEditor {
	protected $parameters;
	
	public function getLocalizationBackingModel($lang) {
		$model = new SimpleFormModel();

		if($this->getProperties()) {
			$params = explode('&', $this->getProperties());
			$param = explode('=', $params[0]);
			$model->setField('redirect_url', $param[1]);
			$param = explode('=', $params[1]);
			$model->setField('redirect_code', $param[1]);
		} else {
			$model->setField('redirect_url', '');
			$model->setField('redirect_code', 301);
		}

		return $model;
	}

	public function getLocalizationViewName($lang) {
		return 'pages/redirect-localization';
	}

	public function validateLocalizationModel(IFormModel $model){
	}

	public function doLocalizationSubmitAction(IFormModel $model) {
		$this->parameters = 'url='.$model->getField('redirect_url').'&code='.$model->getField('redirect_code');
	}

	public function isConfigurable() {
		return false;
	}

	public function getConfigurationBackingModel(){
		return null;
	}

	public function getConfigurationViewName(){
	}

	public function validateConfigurationModel(IFormModel $model){
	}

	public function doConfigurationSubmitAction(IFormModel $model){
	}
	
	public function isConfigurationUpdatedProperties() {
		return false;
	}
	
	public function getUpdatedProperties(IFormModel $model){
		$this->parameters = 'url='.$model->getField('redirect_url').'&code='.$model->getField('redirect_code');
		return $this->parameters;
	}
}
?>
