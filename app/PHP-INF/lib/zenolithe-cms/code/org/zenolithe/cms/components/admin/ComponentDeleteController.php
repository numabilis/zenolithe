<?php
namespace org\zenolithe\cms\components\admin;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\forms\SimpleFormModel;
use org\zenolithe\kernel\mvc\forms\SimpleFormController;
use org\zenolithe\kernel\mvc\forms\Validator;
use org\zenolithe\kernel\mvc\forms\IFormModel;

require daf_file('zenolithe/cms/layouts-admin.daf');
require daf_file('zenolithe/cms/components-admin.daf');

class ComponentDeleteController extends SimpleFormController {
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
			$layouts = select_layouts_by_component_id($id);
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
		}
		$editor->role = $this->componentRole;
		$model->setAttribute('cpt_editor', $editor);
		$model->setAttribute('cpt_id', $editor->getId());
		$model->setAttribute('cpt_name', $editor->getName());

		return $model;
	}

	protected function validate(IFormModel $model) {
	}
	
	protected function doSubmitAction(IFormModel $model) {
		$editor = $model->getAttribute('cpt_editor');
		$editor->delete($model);
 		delete_component($model->getAttribute('cpt_id'));
		$this->redirect('list.php');
	}
}