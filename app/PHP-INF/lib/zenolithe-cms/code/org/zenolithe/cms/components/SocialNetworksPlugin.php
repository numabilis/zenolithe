<?php
namespace org\zenolithe\cms\components;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\controllers\IController;
use org\zenolithe\kernel\mvc\SimpleModel;
use org\zenolithe\cms\page\IPageModel;

class SocialNetworksPlugin extends Component {
	public function preHandle(Request $request, IController $controller) {
		\org_zenolithe_cms_ComponentRegistry::put('SocialNetworksPlugin', $this);
		
		return null;
	}
	
	public function getComponentModel(Request $request, IPageModel $pageModel, $lang) {
		$model = new SimpleModel();
		
		$socialModel = array();
		$parameters = explode('#', $this->parameter);
		foreach($parameters as $parameter){
			$vars = preg_split('/=/', $parameter);
			if (count($vars)>1){
				$socialModel[$vars[0]] = $vars[1];
			}
		}
		if($pageModel->getMetaTitle()){
			$socialModel['og:title'] = $pageModel->getMetaTitle();
		}
		if($pageModel->getMetaDescription()){
			$socialModel['og:description'] = $pageModel->getMetaDescription();
		}
		if($pageModel->getCanonical()){
			$socialModel['og:url'] = $pageModel->getCanonical();
		}
		if($pageModel->get('social-networks-og:image')) {
			$socialModel['og:image'] = $pageModel->get('social-networks-og:image');
		}
		$model->set('social-networks', $socialModel);
		
		return $model;
	}

	public function viewName() {
		return 'components/socialnetworks';
	}
	
	public function getZone() {
		return 'head';
	}
}
?>
