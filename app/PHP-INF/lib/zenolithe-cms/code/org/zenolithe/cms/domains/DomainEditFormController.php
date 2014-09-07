<?php
namespace org\zenolithe\cms\domains;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\ioc\IocContainer;
use org\zenolithe\kernel\mvc\forms\SimpleFormController;
use org\zenolithe\kernel\mvc\forms\Validator;
use org\zenolithe\kernel\mvc\forms\SimpleFormModel;
use org\zenolithe\kernel\mvc\forms\IFormModel;

require daf_file('zenolithe/cms/domains-admin.daf');
//require daf_file('zenolithe/cms/components-admin.daf');

class DomainEditFormController extends SimpleFormController {
	protected function formBackingModel(Request $request) {
		$model = new SimpleFormModel();

		$model->setAttribute('dom_id', 0);
		$model->setField('dom_mnem', '');
		$model->setField('dom_base', '');
		$model->setField('dom_languages', '');

		return $model;
	}

	protected function validate(IFormModel $model) {
		if(strlen(trim($model->getField('dom_mnem'))) != 3) {
			$model->rejectValue('dom_mnem','Longueure différente de 3.');
		}
		if(!Validator::isValid($model->getField('dom_base'), URL)) {
			$model->rejectValue('dom_base','URL invalide');
		}
	}

	protected function doSubmitAction(IFormModel $model) {
		$model->setField('dom_mnem', trim($model->getField('dom_mnem')));
		if(strrpos($model->getField('dom_base'), '/') != strlen($model->getField('dom_base'))-1) {
			$model->setField('dom_base', $model->getField('dom_base').'/');
		}
		$model->setField('dom_languages', strtolower($model->getField('dom_languages')));
		$model->setAttribute('dom_id', insert_domain($model->getField('dom_mnem'), $model->getField('dom_base'), $model->getField('dom_languages')));
		$domain = select_domain_by_id($model->getAttribute('dom_id'));
		$session = IocContainer::getInstance()->get('session');
		$session->setAttribute('edited-domain', $domain);
		$this->redirect('switch.php');
	}
}
?>