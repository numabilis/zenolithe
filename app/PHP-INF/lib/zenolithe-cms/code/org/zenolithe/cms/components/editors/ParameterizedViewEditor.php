<?php
namespace org\zenolithe\cms\components\editors;

use org\zenolithe\kernel\mvc\forms\IFormModel;

class ParameterizedViewEditor extends ComponentEditor {
	private $view =  '';

	public function configure($conf) {
		$this->view = $conf['view'];
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
		return null;
	}

	function getConfigurationViewName() {
		return null;
	}

	function validateConfigurationModel(IFormModel $model) {
	}

	function doConfigurationSubmitAction(IFormModel $model) {
	}

	function delete(IFormModel $model) {
	}
	
	function getParameter() {
		return $this->view;
	}
}
?>
