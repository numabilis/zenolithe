<?php
/*
 *
 * Created on 6 déc. 06 by David Jourand
 *
 */
namespace org\zenolithe\kernel\mvc\interceptors;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\IModel;
use org\zenolithe\kernel\mvc\controllers\IController;

class DecorateInterceptor implements IInterceptor {
  protected $decorators = array();
  
  public function setDecorators($decorators) {
  	$this->decorators = $decorators;
  }
  
  public function preHandle(Request $request, IController $controller) {
    return null;
  }
  
  public function postHandle(Request $request, IController $controller, IModel $model) {
    foreach($this->decorators as $decorator) {
      $decorator->decorate($request, $controller, $model);
    }
  }

  public function afterCompletion(Request $request, IController $controller) {
  }
}
?>
