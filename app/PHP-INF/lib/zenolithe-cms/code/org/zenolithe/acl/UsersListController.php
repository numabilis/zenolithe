<?php
use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\SimpleModel;
use org\zenolithe\kernel\mvc\controllers\IController;

require daf_file('zenolithe/acl/users-admin.daf');

class org_zenolithe_acl_UsersListController implements IController {
	public $view ;
	
	public function handleRequest(Request $request) {
		$model = new SimpleModel();
		
		$model->set('users', select_all_users());
		$model->setViewName($this->view);
		
		return $model;
	}
}
?>
