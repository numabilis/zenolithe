<?php
namespace org\zenolithe\cms\components\editors;

use org\zenolithe\kernel\mvc\forms\IFormModel;

abstract class ComponentEditor {
	private $id;
	private $siteId;
	private $name;
	private $type;
	private $class;
	private $substituteId;
	private $supportedLangs;
	private $param;
	private $lang;
	public $role;

	public final function getId() {
		return $this->id;
	}

	public final function setId($id) {
		$this->id = $id;
	}

	public final function getSiteId() {
		return $this->siteId;
	}

	public final function setSiteId($id) {
		$this->siteId = $id;
	}

	public final function getName() {
		return $this->name;
	}

	public final function setName($name) {
		$this->name = $name;
	}

	public final function getType() {
		return $this->type;
	}

	public final function setType($type) {
		$this->type = $type;
	}

	public final function getClass() {
		return $this->class;
	}

	public final function setClass($name) {
		$this->class = $name;
	}

	public final function getSubstituteId() {
		return $this->substituteId;
	}

	public final function setSubstituteId($substituteId) {
		$this->substituteId = $substituteId;
	}

	public final function getSupportedLangs() {
		return $this->supportedLangs;
	}

	public final function setSupportedLangs($supportedLangs) {
		$this->supportedLangs = $supportedLangs;
	}

	public final function getParam() {
		return $this->param;
	}

	public final function setParam($parameter) {
		$this->param = $parameter;
	}

	public final function getLang() {
		return $this->lang;
	}

	public final function setLang($lang) {
		$this->lang = $lang;
	}

	public function configure($conf) {
	}

	public abstract function getConfigurationBackingModel();
	public abstract function getConfigurationViewName();
	public abstract function validateConfigurationModel(IFormModel $model);
	public abstract function doConfigurationSubmitAction(IFormModel $model);
	public abstract function getParameter();
	public abstract function isLocalizable();
	public abstract function getLocalizationBackingModel($lang);
	public abstract function getLocalizationViewName($lang);
	public abstract function validateLocalizationModel(IFormModel $model);
	public abstract function doLocalizationSubmitAction(IFormModel $model);
	public abstract function delete(IFormModel $model);
}
?>