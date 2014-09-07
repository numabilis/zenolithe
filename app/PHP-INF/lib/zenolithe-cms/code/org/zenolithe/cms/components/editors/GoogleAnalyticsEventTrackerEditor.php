<?php
namespace org\zenolithe\cms\components\editors;

use org\zenolithe\kernel\mvc\forms\SimpleFormModel;
use org\zenolithe\kernel\mvc\forms\Validator;
use org\zenolithe\kernel\mvc\forms\IFormModel;

require daf_file('zenolithe/cms/components/google-analytics.daf');
require daf_file('zenolithe/cms/components/google-analytics-admin.daf');

class GoogleAnalyticsEventTrackerEditor extends ComponentEditor {
	private $newRecord = true;

	function isLocalizable() {
		return true;
	}

	function getLocalizationBackingModel($lang) {
		$model = new SimpleFormModel();

		$gaq = select_gaq($this->getId(), $lang);
		if($gaq) {
			$model->setField('gaq_category', $gaq['gaq_category']);
			$model->setField('gaq_action', $gaq['gaq_action']);
			$model->setField('gaq_label', $gaq['gaq_label']);
			$model->setField('gaq_value', $gaq['gaq_value']);
			$this->newRecord = false;
		} else {
			$model->setField('gaq_category', '');
			$model->setField('gaq_action', '');
			$model->setField('gaq_label', '');
			$model->setField('gaq_value', '');
		}

		return $model;
	}

	function getLocalizationViewName($lang) {
		return 'components/google-analytics/localization';
	}

	function validateLocalizationModel(IFormModel $model) {
		if(!Validator::isValid($model->getField('gaq_category'), BASICTEXT)) {
			$model->rejectValue('gaq_category', 'Invalide');
		}
		if(!Validator::isValid($model->getField('gaq_action'), BASICTEXT)) {
			$model->rejectValue('gaq_action', 'Invalide');
		}
		if(($model->getField('gaq_label') != '') && !Validator::isValid($model->getField('gaq_label'), BASICTEXT)) {
			$model->rejectValue('gaq_label', 'Invalide');
		}
		if(($model->getField('gaq_value') != '') && !Validator::isValid($model->getField('gaq_value'), BASICTEXT)) {
			$model->rejectValue('gaq_value', 'Invalide');
		}
	}

	function doLocalizationSubmitAction(IFormModel $model) {
		if($this->newRecord) {
			insert_gaq($this->getId(), $this->getLang(), $model->getField('gaq_category'), $model->getField('gaq_action'), $model->getField('gaq_label'), $model->getField('gaq_value'));
		} else {
			update_gaq($this->getId(), $this->getLang(), $model->getField('gaq_category'), $model->getField('gaq_action'), $model->getField('gaq_label'), $model->getField('gaq_value'));
		}
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

	function getParameter() {
		return '';
	}
	
	function delete(IFormModel $model) {
		delete_all_gaq($this->getId());
	}
}
?>
