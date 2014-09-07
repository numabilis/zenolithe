<?php
/*
 *
 * Created on 13 juin 07 by David Jourand
 *
 * This class is designed to be the controller of pages embeding multiple forms.
 *
 */
namespace org\zenolithe\kernel\mvc\forms;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\forms\SimpleFormModel;

class MultiFormController extends SimpleFormController {
  public $formControllers = array();
  
  protected function formBackingModel(Request $request) {
    $model = new SimpleFormModel();
    
    foreach($this->formControllers as $formController) {
      $formController->formBackingModelForm($request, $model);
    }
    $model->setField('submitted_form_name', '');
    
    return $model;
  }
  
  protected function validate(IFormModel $model) {
    if($model->getField('submitted_form_name')) {
      if(isset($this->formControllers[$model->getField('submitted_form_name')])) {
        $this->formControllers[$model->getField('submitted_form_name')]->validateForm($model);
      } else {
        $model->reject('submitted_form_name_invalid');
        error('submitted_form_name_invalid');
      }
    } else {
      $model->reject('submitted_form_name_undefined');
      error('submitted_form_name_undefined');
    }
  }
  
  protected function doSubmitAction(IFormModel $model) {
    $this->formControllers[$model->getField('submitted_form_name')]->doSubmitActionForm($model);
    if(isset($this->formControllers[$model->getField('submitted_form_name')]->successView)) {
      $this->successView = $this->formControllers[$model->getField('submitted_form_name')]->successView;
    }
  }
}
?>
