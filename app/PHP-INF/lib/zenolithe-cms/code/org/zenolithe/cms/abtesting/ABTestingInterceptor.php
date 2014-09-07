<?php
namespace org\zenolithe\cms\abtesting;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\controllers\IController;
use org\zenolithe\kernel\mvc\interceptors\IInterceptor;

class ABTestingInterceptor implements IInterceptor {
	private $iocContainer;
	private $urlBuilder;
	private $abtestsDao;
	private $abTest;
	
	public function setIocContainer($iocContainer) {
		$this->iocContainer = $iocContainer;
	}
	
	public function setUrlBuilder($urlBuilder) {
		$this->urlBuilder = $urlBuilder;
	}
	
	public function setABTestsDao($abtestsDao) {
		$this->abtestsDao = $abtestsDao;
	}
	
	public function preHandle(Request $request, IController $controller) {
		global $context;
		
		$abtest = $this->abtestsDao->getTestByUriAndLang($this->urlBuilder->getbaseUrl(), $request->url, $context->locale);
		if($abtest) {
			$this->abTest = $abtest;
			ob_start();
			$cpt = $this->iocContainer->get('templating');
			$cpt->addDesktopTemplate($this->parameter);
		}
		
		return false;
	}

 	public function postHandle(Request $request, IController $controller, &$modelAndView) {
 	}

	public function afterCompletion(Request $request, IController $controller) {
		if($this->abTest){
			debug($this->abTest);
			$html = ob_get_clean();
			$html = str_replace($this->abTest->getUri(), $this->abTest->getParameter(), $html);
			echo $html;
			ob_end_flush();
		}
	}
}
?>
