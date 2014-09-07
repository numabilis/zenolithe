<?php
namespace org\zenolithe\acl;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\forms\SimpleFormController;
use org\zenolithe\kernel\mvc\forms\Validator;
use org\zenolithe\kernel\mvc\forms\SimpleFormModel;
use org\zenolithe\kernel\mvc\forms\IFormModel;

require daf_file('zenolithe/acl/aro-admin.daf');
require daf_file('zenolithe/acl/users-admin.daf');
require 'code/org/zenolithe/acl/acl-admin.php';
require 'code/org/zenolithe/acl/acl-request.php';
require 'code/org/zenolithe/acl/users-definitions.php';

class UserEditFormController extends SimpleFormController{
	protected function formBackingModel(Request $request) {
		$model = new SimpleFormModel();
		
		if($request->getParameter('usr_id') != "") {
			$user = select_user_by_id($request->getParameter('usr_id'));
			$model->setAttribute('usr_id', $user['usr_id']);
			$model->setField('usr_last_name', $user['usr_last_name']);
			$model->setField('usr_first_name', $user['usr_first_name']);
			$model->setField('usr_login', $user['usr_login']);
			$model->setField('usr_password', $user['usr_password']);
			$model->setField('usr_email', $user['usr_email']);
			$model->setField('usr_profile', $user['usr_profile']);
		} else {
			$model->setAttribute('usr_id', 0);
			$model->setField('usr_last_name', '');
			$model->setField('usr_first_name', '');
			$model->setField('usr_login', '');
			$model->setField('usr_password', '');
			$model->setField('usr_email', '');
			$model->setField('usr_profile', '');
		}
		
		return $model;
	}
	
	protected function validate(IFormModel $model) {
		if(!Validator::isValidName($model->getField('usr_last_name'))) {
			$model->rejectValue('usr_last_name','Nom invalide');
		}
		if(!Validator::isValidName($model->getField('usr_first_name'))) {
			$model->rejectValue('usr_first_name','Prénom invalide');
		}
		if(!Validator::isValid($model->getField('usr_login'), ALPHANUM)) {
			$model->rejectValue('usr_login','Login invalide');
		}
		if($model->getAttribute('usr_id') == 0) {
			if(strlen($model->getField('usr_password')) < 4) {
				$model->rejectValue('usr_password','Mot de passe invalide');
			}
		}
		if(!Validator::isValidEmail($model->getField('usr_email'))) {
			$model->rejectValue('usr_email','Email invalide');
		}
		if(($model->getField('usr_profile') != 'admin_app') && ($model->getField('usr_profile') != 'admin_site')) {
			$model->rejectValue('usr_profile','Profil invalide');
		}
	}
	
	protected function doSubmitAction(IFormModel $model) {
		if($model->getAttribute('usr_id') != 0) {
			update_user($model->getAttribute('usr_id'), $model->getField('usr_first_name'), $model->getField('usr_last_name'), $model->getField('usr_login'), $model->getField('usr_email'), $model->getField('usr_profile'));
			if($model->getField('usr_profile') == 'admin_app') {
				aro_groups_delete($model->getAttribute('usr_id'), ARO_TYPE_USER, GROUP_ADMINS_SITE);
				aro_groups_delete($model->getAttribute('usr_id'), ARO_TYPE_USER, GROUP_ADMINS_APP);
				aro_groups_create($model->getAttribute('usr_id'), ARO_TYPE_USER, GROUP_ADMINS_APP);
			} else {
				aro_groups_delete($model->getAttribute('usr_id'), ARO_TYPE_USER, GROUP_ADMINS_SITE);
				aro_groups_delete($model->getAttribute('usr_id'), ARO_TYPE_USER, GROUP_ADMINS_APP);
				aro_groups_create($model->getAttribute('usr_id'), ARO_TYPE_USER, GROUP_ADMINS_SITE);
			}
		} else {
			$model->setAttribute('usr_id', insert_user($model->getField('usr_first_name'), $model->getField('usr_last_name'), $model->getField('usr_login'), $model->getField('usr_email'), $model->getField('usr_password'), $model->getField('usr_profile')));
			if($model->getField('usr_profile') == 'admin_app') {
				aro_groups_create($model->getAttribute('usr_id'), ARO_TYPE_USER, GROUP_ADMINS_APP);
			} else {
				aro_groups_create($model->getAttribute('usr_id'), ARO_TYPE_USER, GROUP_ADMINS_SITE);
			}
		}
		$this->redirect('list.php');
	}
}