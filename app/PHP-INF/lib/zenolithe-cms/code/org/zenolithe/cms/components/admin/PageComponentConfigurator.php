<?php
namespace org\zenolithe\cms\components\admin;

use org\zenolithe\kernel\mvc\forms\IFormModel;

abstract class PageComponentConfigurator {
	protected $pageId;
	
	public final function getPageId() {
		return $this->pageId;
	}
	
	public final function setPageId($pageId) {
		$this->pageId = $pageId;
	}
	
	public abstract function getLocalizationBackingModel($lang);
	public abstract function getLocalizationViewName($lang);
	public abstract function validateLocalizationModel(IFormModel $model);
	public abstract function doLocalizationSubmitAction(IFormModel $model);
}
?>