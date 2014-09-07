<?php
/*
 *
 * Created on 26 avr. 07 by David Jourand
 *
 */
namespace org\zenolithe\kernel\mvc\forms;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\forms\SimpleFormModel;

class AggregatedFormController extends SimpleFormController {
  public $formPartControllers = array();
  
  protected function formBackingModel(Request $request) {
    $model = new SimpleFormModel();
    
    foreach($this->formPartControllers as $formPartController) {
      $formPartController->formBackingModelPart($request, $model);
    }
    
    return $model;
  }
  
  protected function validate(IFormModel $model) {
    foreach($this->formPartControllers as $formPartController) {
      $formPartController->validatePart($model);
    }
  }
  
  protected function doSubmitAction(IFormModel $model) {
    foreach($this->formPartControllers as $formPartController) {
      $formPartController->doSubmitActionPart($model);
    }
  }
}
?>
