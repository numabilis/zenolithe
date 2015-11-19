<?php
namespace org\zenolithe\security\guards;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\http\Url;
use org\zenolithe\kernel\http\UrlProvider;
use org\zenolithe\kernel\mvc\IModel;
use org\zenolithe\kernel\mvc\SimpleModel;
use org\zenolithe\kernel\mvc\controllers\IController;
use org\zenolithe\kernel\mvc\interceptors\IInterceptor;

class ClientIPBasedGuard implements IInterceptor {
	protected $allowedIps = null;
	protected $rejectView;
	
	public function setAllowedIps($allowedIps) {
		$this->allowedIps = $allowedIps;
	}
	
	public function setRejectView($rejectView) {
		$this->rejectView = $rejectView;
	}

	public function preHandle(Request $request, IController $controller) {
		$model = null;
		
		if(!in_array($request->getUserHostAddress(), $this->allowedIps)) {
			$model = new SimpleModel();
			$model->setViewName($this->rejectView);
		}
		
		return $model;
	}

	public function postHandle(Request $request, IController $controller, IModel $model) {
	}
	
	public function afterCompletion(Request $request, IController $controller) {
	}
}
?>