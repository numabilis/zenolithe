<?php
/**
 * 29-mai-06 - david : Creation
 *
 */

namespace org\zenolithe\kernel\mvc\controllers;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\SimpleModel;

class SimpleController implements IController {
  private $viewName;
  private $model;
  
  public function getViewName() {
  	return $this->viewName;
  }
  
  public function setViewName($viewName) {
  	$this->viewName = $viewName;
  }
  
  public function buildModel(Request $request) {
  	$this->model = new SimpleModel();
  	
    return $this->model;
  }

  public function setModel($model) {
  	$this->model = $model;
  }
  
  public function handleRequest(Request $request) {
  	$model = $this->buildModel($request);
  	$model->setViewName($this->viewName);
  	
    return $model;
  }
}
?>
