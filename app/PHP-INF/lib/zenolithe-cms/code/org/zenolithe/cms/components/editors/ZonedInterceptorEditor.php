<?php
namespace org\zenolithe\cms\components\editors;

use org\zenolithe\kernel\mvc\forms\SimpleFormModel;
use org\zenolithe\cms\components\editors\ComponentEditor;
use org\zenolithe\kernel\mvc\forms\IFormModel;

abstract class ZonedInterceptorEditor extends ComponentEditor {
	private $zone;
	private $configuration = false;

	function getConfigurationBackingModel() {
		$model = new SimpleFormModel();
		
		$model->setField('zone', '');
		if($this->role == 'interceptor') {
			$model->setField('zone', $this->getParam());
			$model->setAttribute('zones', array('Après balise BODY ouvrante' => 'body-begin',
															'Avant balise BODY fermante' => 'body-end',
															'En-tête HTML' => 'head'));
		}

		return $model;
	}

	function getConfigurationViewName() {
		$view = null;
			
		if($this->role == 'interceptor') {
			$view = 'components/zoned-interceptor-configuration';
		}
			
		return $view;
	}

	function validateConfigurationModel(IFormModel $model) {
	}

	function doConfigurationSubmitAction(IFormModel $model) {
		$this->configuration = true;
		$this->zone = $model->getField('zone');
	}

	function delete(IFormModel $model) {
	}
	
	function getParameter() {
		if($this->configuration) {
			$parameter = $this->zone;
		} else {
			$parameter = $this->getParam();
		}

		return $parameter;
	}
}
?>
