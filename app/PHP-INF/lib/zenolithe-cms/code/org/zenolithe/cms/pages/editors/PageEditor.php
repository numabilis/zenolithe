<?php
namespace org\zenolithe\cms\pages\editors;

use org\zenolithe\kernel\mvc\forms\IFormModel;

abstract class PageEditor {
	protected $pageId = 0;
	private $controllerClass;
	private $previewControllerClass;
	private $properties;
	private $localizationView;

	public final function setPageId($pageId) {
		$this->pageId = $pageId;
	}

	public final function getControllerClass() {
		return $this->controllerClass;
	}

	public final function getPreviewControllerClass() {
		return $this->previewControllerClass;
	}

	public final function setControllerClass($controllerClass) {
		$this->controllerClass = $controllerClass;
	}

	public final function setPreviewControllerClass($previewControllerClass) {
		$this->previewControllerClass = $previewControllerClass;
	}

	public final function getProperties() {
		return $this->properties;
	}

	public final function setProperties($properties) {
		$this->properties = $properties;
	}

	public function configure($conf) {
	}

	public function setLocalizationViewName($localizationView) {
		$this->localizationView = $localizationView;
	}
	
	public function getLocalizationViewName($lang) {
		return $this->localizationView;
	}
	
	public abstract function isConfigurable();
	public abstract function getConfigurationBackingModel();
	public abstract function getConfigurationViewName();
	public abstract function validateConfigurationModel(IFormModel $model);
	public abstract function doConfigurationSubmitAction(IFormModel $model);
	public abstract function isConfigurationUpdatedProperties();
	public abstract function getUpdatedProperties(IFormModel $model);
	public abstract function getLocalizationBackingModel($lang);
	public abstract function validateLocalizationModel(IFormModel $model);
	public abstract function doLocalizationSubmitAction(IFormModel $model);
}
?>