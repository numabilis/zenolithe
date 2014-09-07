<?php
/**
 * 17-aout-06 - david : Creation
 *
 */
namespace org\zenolithe\kernel\mvc\forms;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\controllers\IController;
use org\zenolithe\kernel\mvc\forms\SimpleFormModel;

// TODO : refactor SimpleFormController to accept GET method
class ValidationController implements IController {
  public $requestParameterNames = array();
  public $successView;
  // if failureView is null, the successView is rendered after unsuccessful validation
  public $failureView;
  public $unboundedParameters = array();
  public $supportedGetMethod = false;
  public $redirect_url;
  
  private function bind(IFormModel $model, Request $request) {
  	if($model) {
  		foreach($model->getFields() as $name => $value) {
  			$newValue = $request->getParameter($name);
  			if(is_bool($value)) {
  				if($newValue == null) {
  					$model->setField($name, false);
  				} else {
  					$model->setField($name, ($newValue == 'true'));
  				}
  			} else {
  				if(!$newValue && is_array($value)) {
  					$model->setField($name, array());
  				} else {
  					$model->setField($name, $newValue);
  				}
  			}
  		}
  	}
  }
  
  private function isMethodSupported(Request $request) {
    $supported = true;
    
    if((!$request->isPostMethod()) && (!$this->supportedGetMethod)) {
      $supported = false;
    }
    
    return $supported;
  }
  
  protected function formBackingModel(Request $request) {
    $model = new SimpleFormModel();
    
    foreach($this->requestParameterNames as $key) {
      $model->setField($key, '');
    }
    
    return $model;
  }
  
  protected function doValidatedAction(IFormModel $model) {}
  
  protected function validate(IFormModel $model) {}
  
  public final function handleRequest(Request $request) {
    $model = null
    
    // We build the initial model...
    $model = $this->formBackingModel($request);
    // ... and update it with the Request supplied parameters ...
    $this->bind($model, $request);
    // ... and validate the model ...
    if($this->isMethodSupported($request)) {
      $this->validate($model);
      // ... if there is no error ...
      if(!$model->hasError()) {
        $this->doValidatedAction($model);
        if ($this->redirect_url) {
          $request->redirect($this->redirect_url);
        } else {
          $model->setViewName($this->successView);
        }
        // ... else there is error(s) ...
      } else {
        // ... so we show the failure view if setted...
        if($this->failureView != null) {
          $model->setViewName($this->failureView);
          // ... the success view otherwise.
        } else {
          $model->setViewName($this->successView);
        }
      }
    } else {
      if($this->failureView != null) {
        $model->setViewName($this->failureView);
        // ... the success view otherwise.
      } else {
        $model->setViewName($this->successView);
      }
    }
    
    return $model;
  }
  
  public function redirect($url) {
    $this->redirect_url = $url;
  }
}
?>
