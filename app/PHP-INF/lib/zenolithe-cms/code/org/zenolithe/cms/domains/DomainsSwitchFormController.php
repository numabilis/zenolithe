<?php
namespace org\zenolithe\cms\domains;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\ioc\IocContainer;
use org\zenolithe\kernel\mvc\forms\SimpleFormController;
use org\zenolithe\kernel\mvc\forms\SimpleFormModel;

require daf_file('zenolithe/cms/domains-admin.daf');

class DomainsSwitchFormController extends SimpleFormController {
	protected function formBackingModel(Request $request) {
		$model = new SimpleFormModel();
		
		$model->setAttribute('edited_domain', $request->getSession()->getAttribute('edited-domain'));
		$model->setAttribute('domains', select_all_domains());
		$model->setField('dom_id', 0);
		
		return $model;
	}
	
	protected function doSubmitAction(IFormModel $model) {
		$session = IocContainer::getInstance()->get('session');
		
		foreach($model->getAttribute('domains') as $domain) {
			if($domain['dom_id'] == $model->getField('dom_id')) {
				$session->setAttribute('edited-domain', $domain);
				break;
			}
		}
		$model->setAttribute('edited_domain', $session->getAttribute('edited-domain'));
		$model->setField('dom_id', 0);
	}
}
?>