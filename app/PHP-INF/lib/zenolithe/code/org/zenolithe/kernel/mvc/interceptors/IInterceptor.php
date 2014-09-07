<?php
namespace org\zenolithe\kernel\mvc\interceptors;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\IModel;
use org\zenolithe\kernel\mvc\controllers\IController;

interface IInterceptor {
	public function preHandle(Request $request, IController $controller);
	public function postHandle(Request $request, IController $controller, IModel $model);
	public function afterCompletion(Request $request, IController $controller);
}
?>
