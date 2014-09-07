<?php
/*
 *
* Created on 27 août 07 by David Jourand
*
*/
namespace org\zenolithe\acl;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\forms\SimpleFormController;
use org\zenolithe\kernel\mvc\forms\SimpleFormModel;
use org\zenolithe\kernel\mvc\forms\IFormModel;

require_once daf_file('zenolithe/acl/users-serving.daf');

class LoginFormController extends SimpleFormController {
  private $redirectUrl = '';
  private $defaultLogin = '';
  private $defaultPassword = '';
  
  public function setRedirectUrl($redirectUrl) {
  	$this->redirectUrl = $redirectUrl;
  }
  
  protected function formBackingModel(Request $request) {
  	$model = new SimpleFormModel();
   	$model->setField('login-form-login', $this->defaultLogin);
   	$model->setField('login-form-password', $this->defaultPassword);
   	$model->setAttribute('login-form-redirect', urldecode($request->getParameter('redirect')));
    if($request->getParameter('login-form-login')) {
     	$model->setField('login-form-login', $request->getParameter('login-form-login'));
    }
    if($request->getParameter('login-form-password')) {
     	$model->setField('login-form-password', $request->getParameter('login-form-password'));
    }
    
    return $model;
  }

  protected function validate(IFormModel $model) {
    $login = $model->getField('login-form-login');
    if(empty($login)) {
      $model->rejectValue('login-form-login', 'login-empty');
    }
    $password = $model->getField('login-form-password');
    if(empty($password)) {
      $model->rejectValue('login-form-password', 'password-empty');
    }
    if((!empty($login)) && (!empty($password))) {
      $user = users_select_by_login_and_password($login, $password);
      if($user == null) {
        $model->rejectValue('login-form-login', 'user-not-found');
//       } else if ($profile->prf_status != PROFILE_STATUS_ACTIVE) {
//         $model->rejectValue('login-form-login', 'account-not-active');
      } else {
        $_SESSION['logged-user'] = $user;
      }
    }
  }

  protected function doSubmitAction(IFormModel $model) {
  	if($model->getAttribute('login-form-redirect')) {
      $this->redirect($model->getAttribute('login-form-redirect'));
  	} else {
  		$this->redirect($this->redirectUrl);
  	}
  }
}
?>
