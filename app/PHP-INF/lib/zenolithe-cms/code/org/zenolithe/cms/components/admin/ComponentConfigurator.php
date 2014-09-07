<?php
namespace org\zenolithe\cms\components\admin;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\forms\SimpleFormModel;
use org\zenolithe\kernel\mvc\forms\SimpleFormController;
use org\zenolithe\kernel\mvc\forms\Validator;
use org\zenolithe\kernel\mvc\forms\IFormModel;

require daf_file('zenolithe/cms/webpage-serving.daf');
require daf_file('zenolithe/cms/contexts-admin.daf');
require daf_file('zenolithe/cms/domains-admin.daf');
require daf_file('zenolithe/cms/components-admin.daf');

class ComponentConfigurator extends SimpleFormController {
	public $componentRole;
	private $componentsPath;
	
	public function setComponentsPath($componentsPath) {
		$this->componentsPath = $componentsPath;
	}
	
	public function setComponentRole($componentRole) {
		$this->componentRole = $componentRole;
	}
	
	protected function formBackingModel(Request $request) {
		$model = new SimpleFormModel();

		$domain = $request->getSession()->getAttribute('edited-domain');
		$model->setAttribute('edited_domain', $domain);
		$id = $request->getParameter('id');
		if($id) {
			$cpt = select_component_by_id($id);
			require $this->componentsPath.$cpt['cpt_type'].'.conf.php';
			$editor = new $component['editor']();
			if(isset($component['editor-configuration'])) {
				$editor->configure($component['editor-configuration']);
			}
			$editor->setId($cpt['cpt_id']);
			$editor->setSiteId($cpt['cpt_site_id']);
			$editor->setName($cpt['cpt_name']);
			$editor->setType($cpt['cpt_type']);
			$editor->setClass($component['class']);
			$editor->setSubstituteId($cpt['cpt_substitute_id']);
			$editor->setSupportedLangs($cpt['cpt_supported_langs']);
			$editor->setParam($cpt['cpt_parameter']);
		} else {
			$type = $request->getParameter('type');
			require $this->componentsPath.$type.'.conf.php';
			$editor = new $component['editor']();
			if(isset($component['editor-configuration'])) {
				$editor->configure($component['editor-configuration']);
			}
			$editor->setSiteId($domain['dom_site_id']);
			$editor->setType($type);
			$editor->setClass($component['class']);
		}
		$editor->role = $this->componentRole;
		$model = $editor->getConfigurationBackingModel();
		if(!$model) {
			$model = new SimpleFormModel();
		}
		$model->setAttribute('cpt_editor', $editor);
		$model->setAttribute('cpt_id', $editor->getId());
		$model->setField('cpt_name', $editor->getName());
		$model->setField('cpt_substitute_id', $editor->getSubstituteId());
		$model->setAttribute('component-configuration-view', $editor->getConfigurationViewName());
		$model->setAttribute('cpt_localizable', $editor->isLocalizable());
		$model->setAttribute('components-list', select_components_by_site_id_and_role($domain['dom_site_id'], $this->componentRole));
		$model->setAttribute('supported_langs', explode(',', $domain['dom_languages']));
		$model->setAttribute('edited_domain', $domain);

		return $model;
	}

	protected function validate(IFormModel $model) {
		$model->getAttribute('cpt_editor')->validateConfigurationModel($model);
		if(!Validator::isValid($model->getField('cpt_name'), BASICTEXT)) {
			$model->rejectValue('cpt_name','Nom invalide');
		}
	}

	protected function doSubmitAction(IFormModel $model) {
		$editor = $model->getAttribute('cpt_editor');
		$editor->doConfigurationSubmitAction($model);
		
		if($model->getAttribute('cpt_id')) {
			$id = $model->getAttribute('cpt_id');
			if($model->getField('cpt_substitute_id') == -1) {
				$model->setField('cpt_substitute_id', $model->getAttribute('cpt_id'));
			}
			if(!$editor->isLocalizable()) {
				update_component($editor->getId(), $editor->getClass(), $model->getField('cpt_name'), $model->getField('cpt_substitute_id'), 'all', $editor->getParameter());
			} else {
				$langs = $editor->getSupportedLangs();
				if($langs == 'all') {
					$langs = '';
				}
				update_component($editor->getId(), $editor->getClass(), $model->getField('cpt_name'), $model->getField('cpt_substitute_id'), $langs, $editor->getParameter());
			}
			$this->redirect('configure.php?id='.$editor->getId());
		} else {
			if(!$editor->isLocalizable()) {
				$id = insert_component($editor->getSiteId(), $model->getField('cpt_name'), $editor->getType(), $this->componentRole, $editor->getClass(), $model->getField('cpt_substitute_id'), 'all', $editor->getParameter());
				$this->redirect('configure.php?id='.$id);
			} else {
				$id = insert_component($editor->getSiteId(), $model->getField('cpt_name'), $editor->getType(), $this->componentRole, $editor->getClass(), $model->getField('cpt_substitute_id'), '', $editor->getParameter());
				$this->redirect('edit.php?id='.$id);
			}
			if($model->getField('cpt_substitute_id') == -1) {
				$model->setField('cpt_substitute_id', $id);
				if(!$editor->isLocalizable()) {
					update_component($id, $editor->getClass(), $model->getField('cpt_name'), $model->getField('cpt_substitute_id'), 'all', $editor->getParameter());
				} else {
					$langs = $editor->getSupportedLangs();
					if($langs == 'all') {
						$langs = '';
					}
					update_component($id, $editor->getClass(), $model->getField('cpt_name'), $model->getField('cpt_substitute_id'), $langs, $editor->getParameter());
				}
			}
		}
	}
}