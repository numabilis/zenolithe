<?php
use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\IModel;
use org\zenolithe\kernel\mvc\controllers\IController;
use org\zenolithe\kernel\mvc\interceptors\IInterceptor;

require daf_file('zenolithe/log/log-serving.daf');

class org_zenolithe_log_UserLogInterceptor implements IInterceptor {
	public $aro_type = ARO_TYPE_USER;
	public $aco_id = 0;
	public $aco_type = ACO_TYPE_ALL;
	public $action = ACL_ACTION_USE;

	public function preHandle(Request $request, IController $controller) {
		return null;
	}

	public function postHandle(Request $request, IController $controller, IModel $model) {
	}

	public function afterCompletion(Request $request, IController $controller) {
		$session = $request->getSession(false);
		if($session) {
			$user = $session->getAttribute('logged-user');
			if($user) {
				insert_log($user['usr_id'], ARO_TYPE_USER, 0, 0, $this->action, $request->url);
			}
		}
	}
}
?>
