<?php
namespace org\zenolithe\cms\components\editors;

use org\zenolithe\kernel\mvc\forms\Validator;
use org\zenolithe\kernel\mvc\forms\SimpleFormModel;
use org\zenolithe\kernel\mvc\forms\IFormModel;

class GalleryBlockEditor extends ComponentEditor {
	private $folderPath = '';
	private $imagesCount = '';

	function isLocalizable() {
		return false;
	}

	function getLocalizationBackingModel($lang) {
		return null;
	}

	function getLocalizationViewName($lang) {
		return '';
	}

	function validateLocalizationModel(IFormModel $model) {
	}

	function doLocalizationSubmitAction(IFormModel $model) {
	}

	function getConfigurationBackingModel() {
		$model = new SimpleFormModel();

		if($this->getParam()) {
			$parameters = explode('#', $this->getParam());
			$this->folderPath = $parameters[0];
			$this->imagesCount = $parameters[1];
		}
		$model->setField('folderPath', $this->folderPath);
		$model->setField('imagesCount', $this->imagesCount);

		return $model;
	}

	function getConfigurationViewName() {
		return 'components/gallery-block-configuration';
	}

	function validateConfigurationModel(IFormModel $model) {
		$this->folderPath = $model->getField('folderPath');
		$this->imagesCount = $model->getField('imagesCount');
	}

	function doConfigurationSubmitAction(IFormModel $model) {
	}

	function delete(IFormModel $model) {
	}
	
	function getParameter() {
		return $this->folderPath.'#'.$this->imagesCount;
	}
}
?>
