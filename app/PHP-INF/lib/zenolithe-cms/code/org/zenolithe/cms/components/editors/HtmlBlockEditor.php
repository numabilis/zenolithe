<?php
namespace org\zenolithe\cms\components\editors;

use org\zenolithe\kernel\mvc\forms\SimpleFormModel;
use org\zenolithe\kernel\mvc\forms\IFormModel;

require daf_file('zenolithe/cms/components/htmlblocks.daf');
require daf_file('zenolithe/cms/components/htmlblocks-admin.daf');

class HtmlBlockEditor extends ZonedInterceptorEditor {
	private $view = '';
	private $newBlock = true;
	
	public function configure($conf) {
		$this->view = $conf['view'];
	}
	
	function isLocalizable() {
		return true;
	}

	function getLocalizationBackingModel($lang) {
		$model = new SimpleFormModel();

		$block = select_htmlblock($this->getId(), $lang);
		if($block) {
			$model->setField('hbk_title', $block['hbk_title']);
			$model->setField('hbk_content', $block['hbk_content']);
			$this->newBlock = false;
		} else {
			$model->setField('hbk_title', '');
			$model->setField('hbk_content', '');
		}

		return $model;
	}

	function getLocalizationViewName($lang) {
		return $this->view;
	}

	function validateLocalizationModel(IFormModel $model) {
	}

	function doLocalizationSubmitAction(IFormModel $model) {
		if($this->newBlock) {
			insert_htmlblock($this->getId(), $this->getLang(), $model->getField('hbk_title'), $model->getField('hbk_content'));
		} else {
			update_htmlblock($this->getId(), $this->getLang(), $model->getField('hbk_title'), $model->getField('hbk_content'));
		}
		if((trim($model->getField('hbk_title')) == '') && ((trim($model->getField('hbk_content')) == '<br>') || (trim($model->getField('hbk_content')) == ''))) {
			delete_htmlblock($this->getId(), $this->getLang());
			$langs = explode('/', $this->getSupportedLangs());
			$supportedLangs = '';
			foreach($langs as $lang) {
				if($lang && ($lang != $this->getLang())) {
					$supportedLangs .= '/'.$lang;
				}
			}
			if($supportedLangs) {
				$supportedLangs .= '/';
			}
			$this->setSupportedLangs($supportedLangs);
			$model->setAttribute('cpt_lang', '');
		}
//		apc_delete('select_htmlblock/'.$this->getId().'/'.$this->getLang());
	}
	
	function delete(IFormModel $model) {
		delete_all_htmlblock($this->getId());
	}
}
?>
