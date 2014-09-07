<?php
namespace org\zenolithe\kernel\mvc\interceptors;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\IModel;
use org\zenolithe\kernel\mvc\controllers\IController;

interface IDecorator {
	public function decorate(Request $request, IController $controller, IModel $model);
}
?>
