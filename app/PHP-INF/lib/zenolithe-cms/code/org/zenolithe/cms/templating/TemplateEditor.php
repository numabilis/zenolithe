<?php
namespace org\zenolithe\cms\templating;

use org\zenolithe\kernel\ioc\IocContainer;
use org\zenolithe\kernel\mvc\forms\SimpleFormModel;
use org\zenolithe\cms\components\editors\ComponentEditor;
use org\zenolithe\kernel\mvc\forms\IFormModel;

require daf_file('zenolithe/cms/components/htmlblocks.daf');
require daf_file('zenolithe/cms/components/htmlblocks-admin.daf');

class TemplateEditor extends ComponentEditor {
	private $parameter;
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

		$this->parameter = $this->getParam();
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
		apc_delete('select_htmlblock/'.$this->getId().'/'.$this->getLang());
	}

	function getConfigurationBackingModel() {
		$model = new SimpleFormModel();

		$templates = array();
		$templates['desktop'] = array();
		$templates['mobile'] = array();
		$folderPath = IocContainer::getInstance()->get('zenolithe.root').IocContainer::getInstance()->get('zenolithe.templates.conf');
		if(is_dir($folderPath)) {
			if($folder = opendir($folderPath)) {
				while(($file = readdir($folder)) !== false) {
					if (pathinfo($file, PATHINFO_EXTENSION) != 'php') {
						continue;
					}
					require $folderPath.$file;
					if(in_array('desktop', $template['types'])) {
						$templates['desktop'][] = $template['name'];
					}
					if(in_array('mobile', $template['types'])) {
						$templates['mobile'][] = $template['name'];
					}
				}
			}
		}
		$model->setAttribute('templates', $templates);
		
		$templateChains = explode('###', $this->getParam());
		
		$templateChain = explode('#', $templateChains[0]);
		$model->setField('desktopTemplateName', $templateChain[0]);
		
		$model->setField('mobileTemplateName', '');
		if(isset($templateChains[1])) {
			$templateChain = explode('#', $templateChains[1]);
			$model->setField('mobileTemplateName', $templateChain[0]);
		}

		return $model;
	}

	function getConfigurationViewName() {
		return 'components/template-configuration';
	}

	function validateConfigurationModel(IFormModel $model) {
		$desktopParameter = '';
		$mobileParameter = '';
		
		$folderPath = IocContainer::getInstance()->get('zenolithe.root').IocContainer::getInstance()->get('zenolithe.templates.conf');
		if(is_dir($folderPath)) {
			if ($folder = opendir($folderPath)) {
				while(($file = readdir($folder)) !== false) {
					if (pathinfo($file, PATHINFO_EXTENSION) != 'php') {
						continue;
					}
					require $folderPath.$file;
					if($model->getField('desktopTemplateName') == $template['name']) {
						$desktopParameter = implode('#', $template['chain']);
					}
					if($model->getField('mobileTemplateName') == $template['name']) {
						$mobileParameter = implode('#', $template['chain']);
					}
				}
			}
		}
		$this->parameter = $desktopParameter.'###'.$mobileParameter;
	}

	function doConfigurationSubmitAction(IFormModel $model) {
	}

	function getParameter() {
		return $this->parameter;
	}
	
	function delete(IFormModel $model) {
		delete_all_htmlblock($this->getId());
	}
}
?>
