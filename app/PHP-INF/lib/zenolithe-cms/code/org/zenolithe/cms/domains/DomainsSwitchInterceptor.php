<?php
namespace org\zenolithe\cms\domains;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\http\UrlProvider;
use org\zenolithe\kernel\mvc\IModel;
use org\zenolithe\kernel\mvc\SimpleModel;
use org\zenolithe\kernel\mvc\controllers\IController;
use org\zenolithe\kernel\mvc\interceptors\IInterceptor;

class DomainsSwitchInterceptor implements IInterceptor {
	public $switchUrl;
	public $protectedUrls;
  private $urlBuilder;
	
	public function setSwitchUrl($switchUrl) {
		$this->switchUrl = $switchUrl;
	}
	
	public function setProtectedUrls($protectedUrls) {
		$this->protectedUrls = $protectedUrls;
	}
  
  public function setUrlBuilder($urlBuilder) {
    $this->urlBuilder = $urlBuilder;
  }
  
	public function preHandle(Request $request, IController $controller) {
		$model = null;
		
		$domain = $request->getSession()->getAttribute('edited-domain');
		if(!$domain && !preg_match($this->protectedUrls, $request->url)) {
			$request->redirect(UrlProvider::getUrl($this->switchUrl));
			$model = new SimpleModel();
		}
		
		return $model;
	}
	
	public function postHandle(Request $request, IController $controller, IModel $model) {
		$model->set('edited_domain', $request->getSession()->getAttribute('edited-domain'));
	}
	
	public function afterCompletion(Request $request, IController $controller) {
	}
}
?>