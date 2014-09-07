<?php
namespace org\zenolithe\cms\components\editors;

use org\zenolithe\kernel\mvc\forms\Validator;
use org\zenolithe\kernel\mvc\forms\SimpleFormModel;
use org\zenolithe\kernel\mvc\forms\IFormModel;

require daf_file('zenolithe/cms/components/clickpics.daf');
require daf_file('zenolithe/cms/components/clickpics-admin.daf');

class ClickPicEditor extends ComponentEditor
{
	private $initialized = false;
	private $localizable = false;
	private $pictureUrl = '';
	private $linkUrl = '';
	private $newRecord = true;

	function isLocalizable() {
		if((!$this->initialized) && $this->getParam()) {
			$attributes = explode(';', $this->getParam());
			$this->localizable = ($attributes[0] == 't');
			$this->pictureUrl = $attributes[1];
			$this->linkUrl = $attributes[2];
			$this->initialized = true;
		}

		return $this->localizable;
	}

	function getLocalizationBackingModel($lang) {
		$model = new SimpleFormModel();

		$clickpic = select_clickpic($this->getId(), $lang);
		if($clickpic) {
			$model->setField('ckp_picture_url', $clickpic['ckp_picture_url']);
			$model->setField('ckp_link_url', $clickpic['ckp_link_url']);
			$this->newRecord = false;
		} else {
			$model->setField('ckp_picture_url', $this->pictureUrl);
			$model->setField('ckp_link_url', $this->linkUrl);
		}

		return $model;
	}

	function getLocalizationViewName($lang){
		return 'components/clickpic/localization';
	}

	function validateLocalizationModel(IFormModel $model){
		if(!Validator::isValid($model->getField('ckp_picture_url'), URL)) {
			$model->rejectValue('ckp_picture_url', 'URL Invalide');
		}
		if(!Validator::isValid($model->getField('ckp_link_url'), URL)) {
			$model->rejectValue('ckp_link_url', 'URL Invalide');
		}
	}

	function doLocalizationSubmitAction(IFormModel $model){
		if($this->newRecord) {
			insert_clickpic($this->getId(), $this->getLang(), $model->getField('ckp_picture_url'), $model->getField('ckp_link_url'));
		} else {
			update_clickpic($this->getId(), $this->getLang(), $model->getField('ckp_picture_url'), $model->getField('ckp_link_url'));
		}
	}

	function getConfigurationBackingModel() {
		$model = new SimpleFormModel();

		if($this->getParam()) {
			$attributes = explode(';', $this->getParam());
			$this->localizable = ($attributes[0] == 't');
			$this->pictureUrl = $attributes[1];
			$this->linkUrl = $attributes[2];
			$this->initialized = true;
		}
		$model->setAttribute('click_pic_localizable', $this->localizable);
		$model->setField('click_pic_picture_url', $this->pictureUrl);
		$model->setField('click_pic_link_url', $this->linkUrl);

		return $model;
	}

	function getConfigurationViewName(){
		return 'components/clickpic/configuration';
	}

	function validateConfigurationModel(IFormModel $model){
		$this->localizable = $model->getAttribute('click_pic_localizable');
		if(!Validator::isValid($model->getField('click_pic_picture_url'), URL)) {
			$model->rejectValue('click_pic_picture_url', 'URL Invalide');
		} else {
			$this->pictureUrl = $model->getField('click_pic_picture_url');
		}
		if(!Validator::isValid($model->getField('click_pic_link_url'), URL)) {
			$model->rejectValue('click_pic_link_url', 'URL Invalide');
		} else {
			$this->linkUrl = $model->getField('click_pic_link_url');
		}
	}

	function doConfigurationSubmitAction(IFormModel $model){
		if(!$this->localizable) {
			delete_clickpics($this->getId());
		}
	}

	function getParameter(){
		if(!$this->localizable) {
			$parameter = 'f;'.$this->pictureUrl.';'.$this->linkUrl;
		} else {
			$parameter = 't;'.$this->pictureUrl.';'.$this->linkUrl;
		}

		return $parameter;
	}
	
	function delete(IFormModel $model) {
		delete_clickpics($this->getId());
	}
}
?>
