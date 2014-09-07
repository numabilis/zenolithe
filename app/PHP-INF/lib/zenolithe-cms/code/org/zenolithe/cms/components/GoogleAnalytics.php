<?php
namespace org\zenolithe\cms\components;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\SimpleModel;
use org\zenolithe\cms\page\IPageModel;

class GoogleAnalytics extends Component {
	public function getComponentModel(Request $request, IPageModel $pageModel, $lang) {
		$model = new SimpleModel();

		$pageModel->addMetaScriptLink('js/ga_social_tracking.js');
		$parameters = explode('#', $this->parameter);
		$model->set('google-analytics-account', $parameters[0]);

		return $model;
	}

	public function viewName() {
		return 'components/ga';
	}
	
	public function getZone() {
		return 'head';
	}
}
?>
