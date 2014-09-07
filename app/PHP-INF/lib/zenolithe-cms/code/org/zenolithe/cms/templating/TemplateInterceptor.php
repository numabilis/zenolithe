<?php
namespace org\zenolithe\cms\templating;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\http\RequestHelper;
use org\zenolithe\kernel\mvc\IModel;
use org\zenolithe\kernel\mvc\SimpleModel;
use org\zenolithe\kernel\mvc\controllers\IController;
use org\zenolithe\kernel\mvc\interceptors\IInterceptor;
use Mobile_Detect;

require daf_file('zenolithe/cms/components/htmlblocks.daf');

class TemplateInterceptor implements IInterceptor {
	public $id;
	public $parameter;
	
	public function addDesktopTemplate($template) {
		$this->parameter = $template.'#'.$this->parameter;
	}
	
	public function preHandle(Request $request, IController $controller) {
		$this->zone = 'body-begin';
		
		$redirect = false;
		
		if($request->getParameter('keepmobile')) {
			if($request->getParameter('keepmobile') == 'true') {
				setcookie('keepmobile', 'true');
			} else {
				setcookie('keepmobile', 'false');
			}
			$reqHelper = RequestHelper::getInstance();
			$url = $reqHelper->urlWithRemovedParameter('keepmobile');
			$request->redirect($url, 303);
			$redirect = true;
		}
		
		return $redirect;
	}

 	public function postHandle(Request $request, IController $controller, IModel $pageModel) {
 		
		$templateChains = explode('###', $this->parameter);
		$templateChain = explode('#', $templateChains[0]);
		$mobilDetector = new Mobile_Detect();
		$keepmobile = (($request->getCookie('keepmobile') == 'true') || ($request->getParameter('keepmobile') == 'true'));
		if(isset($templateChains[1]) && $templateChains[1] && !$keepmobile) {
			if($mobilDetector->isMobile() && !$mobilDetector->isTablet()) {
				$templateChain = explode('#', $templateChains[1]);
			}
		}
		TemplateViewResolver::$templates = $templateChain;
		
		if(isset($templateChains[1]) && $templateChains[1] && $keepmobile && $mobilDetector->isMobile() && !$mobilDetector->isTablet()) {
			$block = select_htmlblock($this->id, $request->getLocale());
			if($block) {
				$hbkCpt = new SimpleModel();
				$hbkCpt->setViewName('view', 'components/mobile-back-link');
				$hbkCpt->set('hbk_title', $block['hbk_title']);
				$hbkCpt->set('hbk_content', $block['hbk_content']);
				$pageModel->addContent('body-begin', $hbkCpt);
			}
		}
		if(!$pageModel->getCanonical()) {
			$pageModel->setCanonical(RequestHelper::getInstance()->canonical());
		}
	}

	public function afterCompletion(Request $request, IController $controller) {
	}
}
?>
