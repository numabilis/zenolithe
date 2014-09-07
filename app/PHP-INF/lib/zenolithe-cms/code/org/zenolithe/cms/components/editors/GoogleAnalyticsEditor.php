<?php
namespace org\zenolithe\cms\components\editors;

use org\zenolithe\kernel\mvc\forms\SimpleFormModel;
use org\zenolithe\kernel\mvc\forms\Validator;
use org\zenolithe\kernel\mvc\forms\IFormModel;

class GoogleAnalyticsEditor extends ComponentEditor {
	private $accountName;

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
		
		$parameters = explode('#', $this->getParam());
		$this->accountName = $parameters[0];
		$model->setField('google_analytics_account', $this->accountName);

		return $model;
	}

	function getConfigurationViewName() {
		return 'components/google-analytics/configuration';
	}

	function validateConfigurationModel(IFormModel $model) {
		if(!Validator::isValid($model->getField('google_analytics_account'), BASICTEXT)) {
			$model->rejectValue('google_analytics_account', 'Invalide');
		} else {
			$this->accountName = $model->getField('google_analytics_account');
		}
	}

	function doConfigurationSubmitAction(IFormModel $model) {
	}

	function delete(IFormModel $model) {
	}
	
	function getParameter() {
		return $this->accountName.'#body-begin';
	}
}
?>
