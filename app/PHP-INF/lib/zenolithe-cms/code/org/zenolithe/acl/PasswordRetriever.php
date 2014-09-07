<?php
use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\forms\SimpleFormController;
use org\zenolithe\kernel\mvc\forms\Validator;
use org\zenolithe\kernel\mvc\forms\SimpleFormModel;
use org\zenolithe\lang\StringHelper;
use org\zenolithe\kernel\mvc\forms\IFormModel;

require daf_file('zenolithe/acl/users-admin.daf');
require daf_file('zenolithe/acl/pwrs.daf');

class org_zenolithe_acl_PasswordRetriever extends SimpleFormController {
	public $mailer;
	
	protected function formBackingModel(Request $request) {
		$model = new SimpleFormModel();
		
		$model->setField('pwr_form_email', '');
		$model->setField('pwr_form_code', '');
		$model->setField('pwr_form_md5', '');
		$model->setAttribute('step', 'email-form');
		
		if($request->getParameter('email')) {
			$model->setField('pwr_form_email', $request->getParameter('email'));
		} else {
			if($request->getParameter('code')) {
				$model->setField('pwr_form_code', $request->getParameter('code'));
			} else {
				$model->setField('pwr_form_code', $request->getParameter('pwr_form_code'));
			}
			if($model->getField('pwr_form_code')) {
				$pwr = select_pwr_by_code($model->getField('pwr_form_code'));
				if(!$pwr) {
					$model->setAttribute('step', 'code-form');
				} else {
					$model->setAttribute('step', 'pw-form');
				}
			}
		}
		
		return $model;
	}
	
	protected function validate(IFormModel $model) {
		switch($model->getAttribute('step')) {
			case 'email-form':
				if(!Validator::isValidEmail($model->getField('pwr_form_email'))) {
					$model->rejectValue('pwr_form_email', 'Email invalide');
				} else {
					$user = users_select_by_email($model->getField('pwr_form_email'));
					if(!$user) {
						$model->rejectValue('pwr_form_email', 'Email introuvable');
					}
				}
				break;
			case 'email-ok':
				break;
			case 'code-form':
				$pwr = select_pwr_by_code($model->getField('pwr_form_code'));
				if(!$pwr) {
					$model->rejectValue('pwr_form_code', 'Code introuvable');
				}
				break;
			case 'pw-form':
				$pwr = select_pwr_by_code($model->getField('pwr_form_code'));
				if(!$pwr) {
					$model->rejectValue('password1', 'Code introuvable');
				}
				if(!$model->getField('pwr_form_md5')) {
					$model->rejectValue('password1', 'Mot de passe vide');
				}
				break;
			case 'pw-ok':
				break;
		}
	}
	
	protected function doSubmitAction(IFormModel $model) {
		switch($model->getAttribute('step')) {
			case 'email-form':
				delete_pwrs($model->getField('pwr_form_email'));
				$code = StringHelper::ansiRand(32);
				insert_pwr($model->getField('pwr_form_email'), $code);
				$model->setAttribute('step', 'email-ok');
				$this->mailer->sendMail($model->getField('pwr_form_email'), $code);
				break;
			case 'email-ok':
				break;
			case 'code-form':
				$this->redirect('?pwr_form_code='.$model->getField('pwr_form_code'));
				break;
			case 'pw-form':
				$pwr = select_pwr_by_code($model->getField('pwr_form_code'));
				update_user_password($model->getField('pwr_form_md5'), $pwr['pwr_email']);
				delete_pwrs($pwr['pwr_email']);
				$model->setAttribute('step', 'pw-ok');
				break;
			case 'pw-ok':
				break;
		}
	}
}
?>