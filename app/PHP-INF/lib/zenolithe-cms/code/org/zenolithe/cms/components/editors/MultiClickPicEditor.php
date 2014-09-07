<?php
namespace org\zenolithe\cms\components\editors;

use org\zenolithe\kernel\mvc\forms\SimpleFormModel;
use org\zenolithe\kernel\mvc\forms\Validator;
use org\zenolithe\kernel\mvc\forms\IFormModel;

require daf_file('zenolithe/cms/components/multiclickpics.daf');
require daf_file('zenolithe/cms/components/multiclickpics-admin.daf');

class MultiClickPicEditor extends ComponentEditor {
	private $pictureUrls;
	private $linkUrls;
	private $minClickPicCount = 3;
	private $clickPicCount = 3;

	function isLocalizable() {
		return true;
	}

	function getLocalizationBackingModel($lang) {
		$model = new SimpleFormModel();

		$multiclickpic = select_multiclickpics($this->getId(), $lang);
		$clickPicCount = count($multiclickpic);
		if($clickPicCount < $this->minClickPicCount) {
			$this->clickPicCount = $this->minClickPicCount;
		} else {
			$this->clickPicCount = $clickPicCount;
		}
		for($i=0; $i < $this->clickPicCount; $i++) {
			if(isset($multiclickpic[$i])) {
				$model->setField('mcp_id_'.$i, $multiclickpic[$i]['mcp_id']);
				$model->setField('mcp_picture_url_'.$i, $multiclickpic[$i]['mcp_picture_url']);
				$model->setField('mcp_link_url_'.$i, $multiclickpic[$i]['mcp_link_url']);
			} else {
				$model->setField('mcp_id_'.$i, 0);
				$model->setField('mcp_picture_url_'.$i, '');
				$model->setField('mcp_link_url_'.$i, '');
			}
		}
		$model->setField('mcp_count', $this->clickPicCount);

		return $model;
	}

	function getLocalizationViewName($lang) {
		return 'components/multiclickpic/localization';
	}

	function validateLocalizationModel(IFormModel $model){
		for($i=0; $i < $this->clickPicCount; $i++) {
			if($model->getField('mcp_picture_url_'.$i) && $model->getField('mcp_link_url_'.$i)) {
				if(!Validator::isValid($model->getField('mcp_picture_url_'.$i), URL)) {
					$model->rejectValue('mcp_picture_url_'.$i, 'URL Invalide');
				}
				if(!Validator::isValid($model->getField('mcp_link_url_'.$i), URL)) {
					$model->rejectValue('mcp_link_url_'.$i, 'URL Invalide');
				}
			}
		}
	}

	function doLocalizationSubmitAction(IFormModel $model) {
		for($i=0; $i < $this->clickPicCount; $i++) {
			if($model->getField('mcp_picture_url_'.$i) && $model->getField('mcp_link_url_'.$i)) {
				if($model->getField('mcp_id_'.$i) == 0) {
					insert_multiclickpic($this->getId(), $this->getLang(), $model->getField('mcp_picture_url_'.$i), $model->getField('mcp_link_url_'.$i));
				} else {
					update_multiclickpic($model->getField('mcp_id_'.$i), $model->getField('mcp_picture_url_'.$i), $model->getField('mcp_link_url_'.$i));
				}
			} else {
				delete_multiclickpic($model->getField('mcp_id_'.$i));
			}
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

	function delete(IFormModel $model) {
		delete_all_multiclickpics($this->getId());
	}
	
	function getParameter() {
		return '';
	}
}
?>
