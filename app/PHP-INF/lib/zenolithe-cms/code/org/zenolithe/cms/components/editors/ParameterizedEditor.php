<?php
namespace org\zenolithe\cms\components\editors;

use org\zenolithe\kernel\mvc\forms\SimpleFormModel;
use org\zenolithe\kernel\mvc\forms\IFormModel;

class ParameterizedEditor extends ComponentEditor {
	private $parameters = '';
	
	public function configure($conf) {
	}

	function isLocalizable() {
		return false;
	}

	function getLocalizationBackingModel($lang) {
		return null;
	}

	function getLocalizationViewName($lang) {
		return null;
	}


	function validateLocalizationModel(IFormModel $model) {
	}

	function doLocalizationSubmitAction(IFormModel $model) {
	}

	function getConfigurationBackingModel() {
		$model = new SimpleFormModel();
		
		$model->setField('parameters', $this->getParam());
		
		return $model;
	}

	function getConfigurationViewName() {
		return 'components/parameterized-configuration';
	}

	function validateConfigurationModel(IFormModel $model) {
	}

	function doConfigurationSubmitAction(IFormModel $model) {
		$this->parameters = $model->getField('parameters');
	}

	function delete(IFormModel $model) {
	}
	
	function getParameter() {
		return $this->parameters;
	}
}
?>
