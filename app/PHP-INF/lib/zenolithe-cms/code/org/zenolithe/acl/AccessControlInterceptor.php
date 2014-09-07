<?php
/*
 * Created on 30 déc. 2008
*
* To change the template for this generated file go to
* Window - Preferences - PHPeclipse - PHP - Code Templates
*/

namespace org\zenolithe\acl;
use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\http\UrlProvider;
use org\zenolithe\kernel\mvc\IModel;
use org\zenolithe\kernel\mvc\SimpleModel;
use org\zenolithe\kernel\mvc\controllers\IController;
use org\zenolithe\kernel\mvc\interceptors\IInterceptor;

require 'code/org/zenolithe/acl/acl-request.php';

class AccessControlInterceptor implements IInterceptor {
  protected $loginUri = '/';
  protected $rejectView = '';
  protected $aro_type = ARO_TYPE_USER;
  protected $aco_id = 0;
  protected $aco_type = ACO_TYPE_ALL;
  protected $action;
  private $urlBuilder;
    
    public function setAction($action) {
    	$this->action = $action;
    }
    
    public function setLoginUri($loginUri) {
    	$this->loginUri = $loginUri;
    }
    
    public function setRejectView($rejectView) {
    	$this->rejectView = $rejectView;
    }
    
  public function setUrlBuilder($urlBuilder) {
    $this->urlBuilder = $urlBuilder;
  }
    
    public function preHandle(Request $request, IController $controller) {
        $model = null;
        
        $loggedUser = $request->getSession()->getAttribute('logged-user');
        if($loggedUser == null) {
          $request->redirect($this->urlBuilder->getUrl($this->loginUri).'?redirect='.urlencode($this->urlBuilder->getUrl($request->url)));
        	$model = new SimpleModel();
        } else {
            $allowed = is_allowed($loggedUser['usr_id'], $this->aro_type, $this->aco_id, $this->aco_type, $this->action);
            if(!$allowed) {
                $model->setViewName($this->rejectView);
            }
        }
        
        return $model;
    }

    public function postHandle(Request $request, IController $controller, IModel $model) {
    }

    public function afterCompletion(Request $request, IController $controller) {
    }
}
?>
