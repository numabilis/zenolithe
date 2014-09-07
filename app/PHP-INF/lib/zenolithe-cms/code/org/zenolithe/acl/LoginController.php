<?php
use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\controllers\IController;

require_once daf_file('zenolithe/acl/users-serving.daf');

class org_zenolithe_acl_LoginController implements IController {
	public $loginUrl = '';
	public $loggedUrl = '';
	
	public function handleRequest(Request $request) { 
		$login = '';
		$password = '';
		
		if($request->getParameter('login-form-login')) {
			$login = $request->getParameter('login-form-login');
		}
		if($request->getParameter('login-form-password')) {
			$password = $request->getParameter('login-form-password');
		}
		$user = users_select_by_login_and_password($login, md5($password));
		if ($user == null) {
			$request->redirect($this->loginUrl.'?login-form-login='.$login);
		} else {
			$_SESSION['logged-user'] = $user;
			$request->redirect($this->loggedUrl);
		}
		
		return null;
	}
}
?>
