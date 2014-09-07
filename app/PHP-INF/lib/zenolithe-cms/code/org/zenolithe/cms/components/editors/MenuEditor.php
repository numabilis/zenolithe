<?php
namespace org\zenolithe\cms\components\editors;

use org\zenolithe\kernel\mvc\forms\SimpleFormModel;
use org\zenolithe\kernel\mvc\forms\IFormModel;

class MenuEditor extends ComponentEditor {
	public $parentGroupId = '';

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
		
		$this->parentGroupId = $this->getParam();
		$model->setField('menu_parent_group_id', $this->parentGroupId);

		return $model;
	}

	function getConfigurationViewName() {
		return 'components/menu-configuration';
	}

	function validateConfigurationModel(IFormModel $model) {
		$this->parentGroupId = $model->getField('menu_parent_group_id');
	}

	function doConfigurationSubmitAction(IFormModel $model) {
	}

	function delete(IFormModel $model) {
	}
	
	function getParameter() {
		return $this->parentGroupId;
	}
}
?>
