<?php
namespace org\zenolithe\cms\components\editors;

use org\zenolithe\kernel\mvc\forms\SimpleFormModel;
use org\zenolithe\kernel\mvc\forms\Validator;
use org\zenolithe\kernel\mvc\forms\IFormModel;

class GoogleAdSenseEditor extends ComponentEditor {
	private $accountName;
	private $slot;

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
		
		$parameters = explode('/', $this->getParam());
		$this->accountName = $parameters[0];
		$this->slot = $parameters[1];
		$model->setField('google_adsense_account', $this->accountName);
		$model->setField('google_adsense_slot', $this->slot);

		return $model;
	}

	function getConfigurationViewName() {
		return 'components/google-adsense/configuration';
	}

	function validateConfigurationModel(IFormModel $model) {
		if(!Validator::isValid($model->getField('google_adsense_account'), BASICTEXT)) {
			$model->rejectValue('google_adsense_account', 'Invalide');
		} else {
			$this->accountName = $model->getField('google_adsense_account');
		}
		if(!Validator::isValidInteger($model->getField('google_adsense_slot'))) {
			$model->rejectValue('google_adsense_slot', 'Invalide');
		} else {
			$this->slot = $model->getField('google_adsense_slot');
		}
	}

	function doConfigurationSubmitAction(IFormModel $model) {
	}

	function delete(IFormModel $model) {
	}
	
	function getParameter() {
		return $this->accountName.'/'.$this->slot;
	}
}
?>
